<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\ScanLog;

class DashboardController extends Controller
{
    public function index()
    {
        if (! auth()->user()->isSuperAdmin()) {
            return redirect()->route('admin.events.index');
        }

        $stats = [
            'total_events' => Event::count(),
            'active_events' => Event::where('is_active', true)->count(),
            'total_attendees' => Attendee::count(),
            'checked_in' => Attendee::where('is_checked_in', true)->count(),
            'total_scans' => ScanLog::count(),
            'success_scans' => ScanLog::where('result', 'success')->count(),
            'pending_registrations' => Attendee::where('registration_status', 'pending')->count(),
        ];

        $recentScans = ScanLog::with(['attendee', 'event'])
            ->latest()
            ->take(10)
            ->get();

        $eventStats = Event::withCount([
            'attendees',
            'attendees as checked_in_count' => fn($q) => $q->where('is_checked_in', true),
        ])->latest()->take(6)->get();

        $eventsByType = Event::selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->get()
            ->keyBy('type');

        return view('admin.dashboard', compact('stats', 'recentScans', 'eventStats', 'eventsByType'));
    }
}
