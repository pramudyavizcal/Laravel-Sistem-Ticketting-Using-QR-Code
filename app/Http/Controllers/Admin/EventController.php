<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::withCount([
            'attendees',
            'attendees as checked_in_count' => fn($q) => $q->where('is_checked_in', true),
        ])->visibleTo(auth()->user())->latest()->paginate(12);

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:wisuda,seminar,konser,workshop',
            'description' => 'nullable|string',
            'venue' => 'required|string|max:255',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'quota' => 'required|integer|min:1',
            'organizer' => 'nullable|string|max:255',
            'theme_color' => 'nullable|string|max:7',
            'is_active' => 'boolean',
            'is_paid' => 'boolean',
            'price' => 'required_if:is_paid,1|numeric|min:0',
            'payment_bank_name' => 'nullable|string',
            'payment_bank_number' => 'nullable|string',
            'payment_bank_holder' => 'nullable|string',
            'allow_manual_transfer' => 'boolean',
            'allow_xendit' => 'boolean',
            'logo' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo_path'] = $request->file('logo')->store('events/logos', 'public');
        }
        if ($request->hasFile('banner')) {
            $validated['banner_path'] = $request->file('banner')->store('events/banners', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_paid'] = $request->boolean('is_paid', false);
        $validated['allow_manual_transfer'] = $request->boolean('allow_manual_transfer', true);
        $validated['allow_xendit'] = $request->boolean('allow_xendit', false);

        $validated['created_by'] = auth()->id();

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dibuat!');
    }

    public function show(Event $event)
    {
        $this->authorizeEvent($event);

        $event->load(['attendees' => fn($q) => $q->latest()]);
        $checkedIn = $event->attendees->where('is_checked_in', true)->count();
        $total = $event->attendees->count();

        return view('admin.events.show', compact('event', 'checkedIn', 'total'));
    }

    public function edit(Event $event)
    {
        $this->authorizeEvent($event);

        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorizeEvent($event);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:wisuda,seminar,konser,workshop',
            'description' => 'nullable|string',
            'venue' => 'required|string|max:255',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'quota' => 'required|integer|min:1',
            'organizer' => 'nullable|string|max:255',
            'theme_color' => 'nullable|string|max:7',
            'is_paid' => 'boolean',
            'price' => 'required_if:is_paid,1|numeric|min:0',
            'payment_bank_name' => 'nullable|string',
            'payment_bank_number' => 'nullable|string',
            'payment_bank_holder' => 'nullable|string',
            'allow_manual_transfer' => 'boolean',
            'allow_xendit' => 'boolean',
            'logo' => 'nullable|image|max:2048',
            'banner' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('logo')) {
            if ($event->logo_path)
                Storage::disk('public')->delete($event->logo_path);
            $validated['logo_path'] = $request->file('logo')->store('events/logos', 'public');
        }
        if ($request->hasFile('banner')) {
            if ($event->banner_path)
                Storage::disk('public')->delete($event->banner_path);
            $validated['banner_path'] = $request->file('banner')->store('events/banners', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_paid'] = $request->boolean('is_paid');
        $validated['allow_manual_transfer'] = $request->boolean('allow_manual_transfer');
        $validated['allow_xendit'] = $request->boolean('allow_xendit');

        $event->update($validated);

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Event berhasil diperbarui!');
    }

    public function destroy(Event $event)
    {
        $this->authorizeEvent($event);

        if ($event->logo_path)
            Storage::disk('public')->delete($event->logo_path);
        if ($event->banner_path)
            Storage::disk('public')->delete($event->banner_path);
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus!');
    }

    public function toggleStatus(Event $event)
    {
        $this->authorizeEvent($event);

        $event->update(['is_active' => !$event->is_active]);
        return back()->with('success', 'Status event diperbarui!');
    }

    private function authorizeEvent(Event $event): void
    {
        abort_if(! auth()->user()->isSuperAdmin() && $event->created_by !== auth()->id(), 403);
    }
}
