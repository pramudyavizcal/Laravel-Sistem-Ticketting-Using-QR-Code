<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Attendee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationConfirmation;
use App\Services\XenditService;

class EventRegistrationController extends Controller
{
    protected $xenditService;

    public function __construct(XenditService $xenditService)
    {
        $this->xenditService = $xenditService;
    }

    // Tampilkan landing page dengan daftar event aktif
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        $eventsQuery = Event::where('is_active', true)
            ->whereDate('event_date', '>=', now()->toDateString());

        if ($search !== '') {
            $eventsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('organizer', 'like', "%{$search}%")
                    ->orWhere('venue', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%");
            });
        }

        $events = $eventsQuery
            ->withCount('attendees')
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $sliderEvents = Event::where('is_active', true)
            ->whereDate('event_date', '>=', now()->toDateString())
            ->withCount('attendees')
            ->latest()
            ->take(5)
            ->get();

        return view('welcome', compact('events', 'sliderEvents', 'search'));
    }

    // Tampilkan detail event & form pendaftaran
    public function show($id)
    {
        $event = Event::withCount('attendees')->findOrFail($id);

        if (!$event->is_active) {
            return redirect('/')->with('error', 'Maaf, pendaftaran untuk event ini sudah ditutup.');
        }

        return view('event-register', compact('event'));
    }

    // Proses pendaftaran peserta
    public function register(Request $request, $id)
    {
        $event = Event::withCount('attendees')->findOrFail($id);

        // Cek Quota
        if ($event->attendees_count >= $event->quota) {
            return back()->with('error', 'Maaf, kuota untuk event ini sudah penuh.');
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|string|max:20',
            'ticket_type' => 'required|string',
            'institution' => 'nullable|string|max:100',
        ]);

        try {
            DB::beginTransaction();

            $ticketCode = strtoupper(substr(Str::slug($event->name), 0, 3)) . '-' . strtoupper(Str::random(8));

            // Default values based on event type
            $regStatus = 'pending';
            $payStatus = $event->is_paid ? 'unpaid' : 'free';
            $payMethod = $event->is_paid ? 'manual' : 'free';

            $attendee = Attendee::create([
                'event_id' => $event->id,
                'ticket_code' => $ticketCode,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'ticket_type' => $request->ticket_type,
                'institution' => $request->institution,
                'registration_status' => $regStatus,
                'payment_status' => $payStatus,
                'payment_method' => $payMethod,
                'is_checked_in' => false,
            ]);

            DB::commit();

            // Kirim email konfirmasi (Pending)
            if ($attendee->email) {
                try {
                    Mail::to($attendee->email)->send(new RegistrationConfirmation($attendee));
                } catch (\Exception $e) {
                    // Silently fail if mail not configured
                }
            }

            // Jika event berbayar, arahkan ke instruksi pembayaran
            if ($event->is_paid) {
                return redirect()->route('event.register.payment', $ticketCode);
            }

            // Jika GRATIS, arahkan ke halaman tunggu approval admin
            return redirect()->route('event.register.pending', $ticketCode);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mendaftar: ' . $e->getMessage());
        }
    }

    // Halaman Instruksi Pembayaran
    public function paymentPage($ticketCode)
    {
        $attendee = Attendee::where('ticket_code', $ticketCode)->firstOrFail();
        $event = $attendee->event;

        if ($attendee->payment_status === 'paid') {
            return redirect()->route('ticket.show', $ticketCode);
        }

        return view('payment-instruction', compact('attendee', 'event'));
    }

    // Submit Bukti Pembayaran
    public function submitPayment(Request $request, $ticketCode)
    {
        $attendee = Attendee::where('ticket_code', $ticketCode)->firstOrFail();

        $request->validate([
            'payment_proof' => 'required|image|max:5120',
        ]);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payments/proofs', 'public');
            $attendee->update([
                'payment_proof_path' => $path,
                // Status tetap pending sampai admin ACC
            ]);
        }

        return redirect()->route('event.register.pending', $ticketCode);
    }

    // Bayar via Xendit
    public function payWithXendit($ticketCode)
    {
        $attendee = Attendee::where('ticket_code', $ticketCode)->firstOrFail();
        $event = $attendee->event;

        if ($attendee->payment_status === 'paid') {
            return redirect()->route('ticket.show', $ticketCode);
        }

        $description = 'Tiket ' . $event->name . ' - ' . $attendee->name;
        $successUrl = route('event.register.pending', $ticketCode); // Balik ke halaman pending setelah sukses
        $failUrl = route('event.register.payment', $ticketCode);    // Balik ke instruksi jika gagal

        try {
            $invoice = $this->xenditService->createInvoice(
                $attendee->ticket_code,
                (int) $event->price,
                $attendee->email,
                $description,
                $successUrl,
                $failUrl
            );

            return redirect($invoice->getInvoiceUrl());
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat pembayaran Xendit: ' . $e->getMessage());
        }
    }

    // Halaman Tunggu Konfirmasi (Success Message)
    public function pendingView($ticketCode)
    {
        $attendee = Attendee::where('ticket_code', $ticketCode)->with('event')->firstOrFail();

        // Jika sudah di-approve, langsung ke tiket
        if ($attendee->registration_status === 'approved') {
            return redirect()->route('ticket.show', $ticketCode);
        }

        return view('registration-pending', compact('attendee'));
    }
}
