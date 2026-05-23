<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketMail;
use App\Mail\RejectionMail;

class AttendeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendee::with('event');

        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(
                fn($q) =>
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('ticket_code', 'like', "%$search%")
                    ->orWhere('seat_number', 'like', "%$search%")
            );
        }
        if ($request->filled('status')) {
            $query->where('is_checked_in', $request->status === 'checked');
        }
        if ($request->filled('reg_status')) {
            $query->where('registration_status', $request->reg_status);
        }

        $attendees = $query->latest()->paginate(20)->withQueryString();
        $events = Event::where('is_active', true)->get();

        return view('admin.attendees.index', compact('attendees', 'events'));
    }

    public function create(Request $request)
    {
        $events = Event::where('is_active', true)->get();
        $selectedEvent = $request->event_id ? Event::find($request->event_id) : null;
        return view('admin.attendees.create', compact('events', 'selectedEvent'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'seat_number' => 'nullable|string|max:50',
            'ticket_type' => 'required|string|max:50',
            'institution' => 'nullable|string|max:255',
            'faculty' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['ticket_code'] = strtoupper(Str::uuid());

        $attendee = Attendee::create($validated);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'attendee' => $attendee]);
        }

        return redirect()->route('admin.attendees.show', $attendee)
            ->with('success', 'Peserta berhasil ditambahkan!');
    }

    public function show(Attendee $attendee)
    {
        $attendee->load(['event', 'scanLogs' => fn($q) => $q->latest()]);
        return view('admin.attendees.show', compact('attendee'));
    }

    public function edit(Attendee $attendee)
    {
        $events = Event::where('is_active', true)->get();
        return view('admin.attendees.edit', compact('attendee', 'events'));
    }

    public function update(Request $request, Attendee $attendee)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'seat_number' => 'nullable|string|max:50',
            'ticket_type' => 'required|string|max:50',
            'institution' => 'nullable|string|max:255',
            'faculty' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $attendee->update($validated);

        return redirect()->route('admin.attendees.show', $attendee)
            ->with('success', 'Data peserta berhasil diperbarui!');
    }

    public function destroy(Attendee $attendee)
    {
        $attendee->delete();
        return redirect()->route('admin.attendees.index')
            ->with('success', 'Peserta berhasil dihapus!');
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getPathname(), 'r');
        $header = fgetcsv($handle); // skip header row
        $count = 0;
        $errors = [];

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 2)
                continue;

            [$name, $email, $phone, $seat, $type, $institution, $faculty, $major] = array_pad($row, 8, null);

            if (empty(trim($name)))
                continue;

            try {
                Attendee::create([
                    'event_id' => $request->event_id,
                    'ticket_code' => strtoupper(Str::uuid()),
                    'name' => trim($name),
                    'email' => trim($email) ?: null,
                    'phone' => trim($phone) ?: null,
                    'seat_number' => trim($seat) ?: null,
                    'ticket_type' => trim($type) ?: 'Regular',
                    'institution' => trim($institution) ?: null,
                    'faculty' => trim($faculty) ?: null,
                    'major' => trim($major) ?: null,
                ]);
                $count++;
            } catch (\Exception $e) {
                $errors[] = "Baris error: $name";
            }
        }
        fclose($handle);

        $msg = "$count peserta berhasil diimport!";
        if ($errors)
            $msg .= ' ' . count($errors) . ' baris gagal.';

        return back()->with('success', $msg);
    }

    public function resetCheckin(Attendee $attendee)
    {
        $attendee->update([
            'is_checked_in' => false,
            'checked_in_at' => null,
            'checked_in_by' => null,
        ]);
        return back()->with('success', 'Check-in peserta berhasil direset!');
    }

    public function approve(Attendee $attendee)
    {
        $updateData = [
            'registration_status' => 'approved',
        ];

        // Jika event berbayar, approval admin dianggap sebagai verifikasi pembayaran lunas
        if ($attendee->event->is_paid) {
            $updateData['payment_status'] = 'paid';
        }

        $attendee->update($updateData);

        // Kirim email sukses (Tiket)
        if ($attendee->email) {
            try {
                Mail::to($attendee->email)->send(new TicketMail($attendee));
            } catch (\Exception $e) {
                // Silently fail or log if mail server not configured
            }
        }

        return back()->with('success', "Pendaftaran {$attendee->name} telah disetujui and tiket dikirim!");
    }

    public function reject(Request $request, Attendee $attendee)
    {
        $request->validate(['reason' => 'nullable|string|max:255']);

        $attendee->update([
            'registration_status' => 'rejected',
            'admin_note' => $request->reason,
        ]);

        // TODO: Kirim email penolakan di tahap 3

        return back()->with('success', "Pendaftaran {$attendee->name} telah ditolak.");
    }
}
