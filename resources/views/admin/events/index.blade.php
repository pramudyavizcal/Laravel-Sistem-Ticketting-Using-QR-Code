@extends('layouts.admin')
@section('title', 'Daftar Event')
@section('page-title', 'Manajemen Event')
@section('breadcrumb', 'Admin / Event')

@section('content')
    <div class="d-flex align-center justify-between mb-3">
        <div>
            <h2 style="font-size:1.5rem;font-weight:800;color:var(--text)">Semua Event</h2>
            <p class="text-muted mt-1">{{ $events->total() }} event terdaftar</p>
        </div>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Buat Event Baru
        </a>
    </div>

    <!-- Filter & Search -->
    <div class="card mb-3">
        <div class="card-body" style="padding:.875rem 1.25rem">
            <form method="GET" class="d-flex gap-2 align-center" style="flex-wrap:wrap">
                <div class="search-input-wrap" style="flex:1;min-width:200px">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" class="form-control" placeholder="Cari event..."
                        value="{{ request('search') }}">
                </div>
                <select name="type" class="form-control" style="width:auto">
                    <option value="">Semua Tipe</option>
                    <option value="wisuda" {{ request('type') === 'wisuda' ? 'selected' : '' }}>🎓 Wisuda</option>
                    <option value="seminar" {{ request('type') === 'seminar' ? 'selected' : '' }}>📚 Seminar</option>
                    <option value="konser" {{ request('type') === 'konser' ? 'selected' : '' }}>🎵 Konser</option>
                    <option value="workshop" {{ request('type') === 'workshop' ? 'selected' : '' }}>🔧 Workshop</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.events.index') }}" class="btn btn-outline">Reset</a>
            </form>
        </div>
    </div>

    <!-- Event Cards Grid -->
    <div class="grid grid-3">
        @forelse($events as $event)
            <div class="card" style="transition:transform .2s,box-shadow .2s;border-top:3px solid {{ $event->theme_color }}">
                <div class="card-body">
                    <div class="d-flex justify-between align-center mb-2">
                        <span class="type-chip type-{{ $event->type }}">
                            {{ $event->type_icon }} {{ $event->type_label }}
                        </span>
                        @if($event->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Nonaktif</span>
                        @endif
                    </div>

                    <h3 style="font-size:.95rem;font-weight:700;color:var(--text);margin:.5rem 0;line-height:1.3">
                        {{ $event->name }}
                    </h3>

                    <div class="text-muted text-sm mb-2">
                        <i class="fas fa-map-marker-alt" style="width:14px"></i> {{ $event->venue }}
                    </div>
                    <div class="text-muted text-sm mb-2">
                        <i class="fas fa-calendar" style="width:14px"></i>
                        {{ $event->event_date->format('d M Y') }} · {{ substr($event->event_time, 0, 5) }} WIB
                    </div>

                    <!-- Progress -->
                    @php
                        $pct = $event->attendees_count > 0
                            ? round($event->checked_in_count / $event->quota * 100)
                            : 0;
                        $fillPct = min(100, $pct);
                    @endphp
                    <div style="margin:.875rem 0">
                        <div class="d-flex justify-between text-sm mb-1">
                            <span style="color:var(--text-muted)">Peserta Terdaftar</span>
                            <span style="color:var(--text);font-weight:700">{{ $event->attendees_count }} / {{ $event->quota }}</span>
                        </div>
                        <div style="background:var(--bg-2);border-radius:4px;height:6px;overflow:hidden">
                            <div
                                style="height:100%;width:{{ min(100, round($event->attendees_count / $event->quota * 100)) }}%;background:{{ $event->theme_color }};border-radius:4px">
                            </div>
                        </div>
                        <div class="d-flex justify-between text-sm mt-1">
                            <span style="color:var(--success)">✅ {{ $event->checked_in_count }} check-in</span>
                            <span style="color:var(--text-muted)">Sisa {{ $event->sisa_kuota }}</span>
                        </div>
                    </div>

                    <div class="d-flex gap-1" style="flex-wrap:wrap">
                        <a href="{{ route('admin.events.show', $event) }}" class="btn btn-outline btn-sm" style="flex:1">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-primary btn-sm" style="flex:1">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.scanner') }}?event_id={{ $event->id }}" class="btn btn-success btn-sm">
                            <i class="fas fa-qrcode"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div style="grid-column:1/-1;text-align:center;padding:4rem 2rem">
                <div style="font-size:4rem;margin-bottom:1rem">📭</div>
                <h3 style="color:var(--text);margin-bottom:.5rem">Belum ada event</h3>
                <p class="text-muted">Buat event pertama Anda sekarang!</p>
                <a href="{{ route('admin.events.create') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-plus"></i> Buat Event
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-between align-center mt-3">
        <div class="text-muted text-sm">
            Menampilkan {{ $events->firstItem() }}–{{ $events->lastItem() }} dari {{ $events->total() }} event
        </div>
        {{ $events->links() }}
    </div>
@endsection