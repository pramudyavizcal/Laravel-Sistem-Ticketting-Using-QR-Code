<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\ScanLog;
use Illuminate\Http\Request;

class ScannerController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::withCount([
            'attendees',
            'attendees as checked_in_count' => fn($q) => $q->where('is_checked_in', true),
        ])->visibleTo(auth()->user())->where('is_active', true)->get();

        $selectedEvent = null;
        if ($request->event_id) {
            $selectedEvent = Event::withCount([
                'attendees',
                'attendees as checked_in_count' => fn($q) => $q->where('is_checked_in', true),
            ])->visibleTo(auth()->user())->findOrFail($request->event_id);
        }

        $recentLogs = collect();
        if ($selectedEvent) {
            $recentLogs = ScanLog::with('attendee')
                ->where('event_id', $selectedEvent->id)
                ->latest()
                ->take(30)
                ->get();
        }

        return view('admin.scanner', compact('events', 'selectedEvent', 'recentLogs'));
    }

    public function verify(Request $request)
    {
        $request->validate([
            'ticket_code' => 'required|string',
            'event_id' => 'required|exists:events,id',
        ]);

        $ticketCode = strtoupper(trim($request->ticket_code));

        abort_unless(Event::visibleTo(auth()->user())->whereKey($request->event_id)->exists(), 403);

        $attendee = Attendee::where('ticket_code', $ticketCode)
            ->where('event_id', $request->event_id)
            ->with('event')
            ->first();

        if (!$attendee) {
            return response()->json([
                'result' => 'invalid',
                'message' => 'QR Code tidak valid atau bukan untuk event ini.',
            ], 200);
        }

        if ($attendee->is_checked_in) {
            ScanLog::create([
                'attendee_id' => $attendee->id,
                'event_id' => $request->event_id,
                'result' => 'duplicate',
                'scanned_by' => auth()->user()->name ?? 'System',
                'device_info' => $request->userAgent(),
            ]);

            return response()->json([
                'result' => 'duplicate',
                'message' => 'Tiket sudah digunakan sebelumnya.',
                'attendee' => [
                    'name' => $attendee->name,
                    'ticket_type' => $attendee->ticket_type,
                    'seat_number' => $attendee->seat_number,
                    'checked_in_at' => $attendee->checked_in_at?->format('d/m/Y H:i'),
                ],
            ], 200);
        }

        // Success: mark as checked in
        $attendee->update([
            'is_checked_in' => true,
            'checked_in_at' => now(),
            'checked_in_by' => auth()->user()->name ?? 'Scanner',
        ]);

        ScanLog::create([
            'attendee_id' => $attendee->id,
            'event_id' => $request->event_id,
            'result' => 'success',
            'scanned_by' => auth()->user()->name ?? 'System',
            'device_info' => $request->userAgent(),
        ]);

        return response()->json([
            'result' => 'success',
            'message' => 'Check-in berhasil!',
            'attendee' => [
                'name' => $attendee->name,
                'ticket_type' => $attendee->ticket_type,
                'seat_number' => $attendee->seat_number,
                'institution' => $attendee->institution,
                'faculty' => $attendee->faculty,
                'event_name' => $attendee->event->name,
            ],
        ], 200);
    }

    public function logs(Request $request)
    {
        $query = ScanLog::with(['attendee', 'event'])
            ->whereHas('event', fn ($eventQuery) => $eventQuery->visibleTo(auth()->user()))
            ->latest();

        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }
        if ($request->filled('result')) {
            $query->where('result', $request->result);
        }

        $logs = $query->paginate(30)->withQueryString();
        $events = Event::visibleTo(auth()->user())->get();

        return view('admin.scan-logs', compact('logs', 'events'));
    }
}
