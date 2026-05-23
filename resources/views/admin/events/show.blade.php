@extends('layouts.admin')
@section('title', $event->name)
@section('page-title', $event->name)
@section('breadcrumb', 'Admin / Event / Detail')

@section('content')
    <!-- Event Header -->
    <div class="card mb-3" style="border-top:4px solid {{ $event->theme_color }}">
        <div class="card-body">
            <div class="d-flex align-center justify-between" style="flex-wrap:wrap;gap:1rem">
                <div class="d-flex align-center gap-2">
                    <div
                        style="width:56px;height:56px;background:{{ $event->theme_color }}22;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.75rem">
                        {{ $event->type_icon }}
                    </div>
                    <div>
                        <div class="d-flex align-center gap-1 mb-1">
                            <span class="type-chip type-{{ $event->type }}">{{ $event->type_label }}</span>
                            @if($event->is_active)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-danger">Nonaktif</span>
                            @endif
                        </div>
                        <h2 style="font-size:1.3rem;font-weight:800;color:var(--text)">{{ $event->name }}</h2>
                        <div class="text-muted text-sm mt-1">
                            {{ $event->organizer }} · {{ $event->vendor ?? $event->venue }}
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-1">
                    <a href="{{ route('admin.scanner') }}?event_id={{ $event->id }}" class="btn btn-success">
                        <i class="fas fa-qrcode"></i> Buka Scanner
                    </a>
                    <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-4 mb-3">
        <div class="stat-card purple">
            <div class="stat-icon" style="background:rgba(108,99,255,.15)">📋</div>
            <div class="stat-value">{{ $event->attendees->count() }}</div>
            <div class="stat-label">Total Peserta</div>
        </div>
        <div class="stat-card green">
            <div class="stat-icon" style="background:rgba(67,233,123,.15)">✅</div>
            <div class="stat-value">{{ $checkedIn }}</div>
            <div class="stat-label">Sudah Check-in</div>
        </div>
        <div class="stat-card orange">
            <div class="stat-icon" style="background:rgba(245,158,11,.15)">⏳</div>
            <div class="stat-value">{{ $total - $checkedIn }}</div>
            <div class="stat-label">Belum Check-in</div>
        </div>
        <div class="stat-card cyan">
            <div class="stat-icon" style="background:rgba(0,201,255,.15)">🎯</div>
            <div class="stat-value">{{ $event->quota }}</div>
            <div class="stat-label">Total Kuota</div>
            <div class="stat-sub">Sisa {{ $event->sisa_kuota }} kursi</div>
        </div>
    </div>

    <!-- Info + Attendees -->
    <div class="grid" style="grid-template-columns:300px 1fr;gap:1rem;align-items:start">
        <!-- Event Info -->
        <div class="card">
            <div class="card-header"><span class="card-title">📋 Detail Event</span></div>
            <div class="card-body">
                @if($event->description)
                    <div style="margin-bottom:1rem;padding-bottom:1rem;border-bottom:1px solid var(--border)">
                        <p style="color:var(--text-muted);font-size:.85rem;line-height:1.6">{{ $event->description }}</p>
                    </div>
                @endif

                <div style="display:flex;flex-direction:column;gap:.7rem">
                    <div class="d-flex align-center gap-2">
                        <i class="fas fa-map-marker-alt" style="color:var(--primary);width:16px"></i>
                        <span class="text-sm">{{ $event->venue }}</span>
                    </div>
                    <div class="d-flex align-center gap-2">
                        <i class="fas fa-calendar" style="color:var(--primary);width:16px"></i>
                        <span class="text-sm">{{ $event->event_date->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex align-center gap-2">
                        <i class="fas fa-clock" style="color:var(--primary);width:16px"></i>
                        <span class="text-sm">{{ substr($event->event_time, 0, 5) }} WIB</span>
                    </div>
                    @if($event->organizer)
                        <div class="d-flex align-center gap-2">
                            <i class="fas fa-building" style="color:var(--primary);width:16px"></i>
                            <span class="text-sm">{{ $event->organizer }}</span>
                        </div>
                    @endif
                </div>

                <div style="margin-top:1.5rem; padding-top:1rem; border-top:1px solid var(--border)">
                    <div
                        style="font-weight:700; font-size:0.85rem; margin-bottom:0.75rem; color:var(--text-muted); text-transform:uppercase">
                        💰 Info Pembayaran</div>
                    <div style="display:flex; flex-direction:column; gap:0.5rem">
                        <div class="d-flex justify-between text-sm">
                            <span class="text-muted">Jenis Event:</span>
                            <span style="font-weight:700">{{ $event->is_paid ? 'Berbayar' : 'Gratis' }}</span>
                        </div>
                        @if($event->is_paid)
                            <div class="d-flex justify-between text-sm">
                                <span class="text-muted">Harga Tiket:</span>
                                <span style="font-weight:700; color:var(--primary)">Rp
                                    {{ number_format($event->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-between text-sm">
                                <span class="text-muted">Transfer Manual:</span>
                                <span style="font-weight:700">{{ $event->allow_manual_transfer ? 'Aktif' : 'Nonaktif' }}</span>
                            </div>
                            @if($event->allow_manual_transfer)
                                <div style="background:var(--bg-2); padding:0.75rem; border-radius:10px; margin-top:0.25rem">
                                    <div class="text-sm" style="font-weight:700">{{ $event->payment_bank_name }}</div>
                                    <div class="text-sm">{{ $event->payment_bank_number }}</div>
                                    <div class="text-sm text-muted">A.n {{ $event->payment_bank_holder }}</div>
                                </div>
                            @endif
                            <div class="d-flex justify-between text-sm">
                                <span class="text-muted">Otomatis Xendit:</span>
                                <span style="font-weight:700">{{ $event->allow_xendit ? 'Aktif' : 'Nonaktif' }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Progress bar -->
                @php $pct = $total > 0 ? round($checkedIn / $total * 100) : 0; @endphp
                <div style="margin-top:1.25rem">
                    <div class="d-flex justify-between text-sm mb-1">
                        <span style="color:var(--text-muted)">Progress Check-in</span>
                        <span style="color:var(--text);font-weight:700">{{ $pct }}%</span>
                    </div>
                    <div style="background:var(--bg-2);border-radius:6px;height:10px;overflow:hidden">
                        <div
                            style="height:100%;width:{{ $pct }}%;background:{{ $event->theme_color }};border-radius:6px;transition:width 1s ease">
                        </div>
                    </div>
                </div>

                <div class="mt-2 d-flex gap-1" style="flex-direction:column">
                    <a href="{{ route('admin.attendees.create') }}?event_id={{ $event->id }}"
                        class="btn btn-primary btn-sm">
                        <i class="fas fa-user-plus"></i> Tambah Peserta
                    </a>
                    <a href="{{ route('admin.attendees.index') }}?event_id={{ $event->id }}" class="btn btn-outline btn-sm">
                        <i class="fas fa-list"></i> Lihat Semua Peserta
                    </a>
                </div>
            </div>
        </div>

        <!-- Attendees List -->
        <div class="card">
            <div class="card-header">
                <span class="card-title">👥 Daftar Peserta</span>
                <span class="text-muted text-sm">{{ $event->attendees->count() }} peserta</span>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Tiket</th>
                            <th>Jenis Tiket</th>
                            <th>Kursi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($event->attendees->take(20) as $i => $att)
                            <tr>
                                <td class="text-muted text-sm">{{ $i + 1 }}</td>
                                <td>
                                    <div style="font-weight:600;color:var(--text)">{{ $att->name }}</div>
                                    <div class="text-sm text-muted">{{ $att->email }}</div>
                                </td>
                                <td>
                                    <code
                                        style="font-size:.7rem;color:var(--primary);background:rgba(108,99,255,.1);padding:.15rem .4rem;border-radius:4px">
                                                {{ Str::limit($att->ticket_code, 13) }}
                                            </code>
                                </td>
                                <td><span class="badge badge-info">{{ $att->ticket_type }}</span></td>
                                <td class="text-sm">{{ $att->seat_number ?? '—' }}</td>
                                <td>
                                    @if($att->is_checked_in)
                                        <span class="badge badge-success">✅ Check-in</span>
                                    @else
                                        <span class="badge badge-warning">⏳ Belum</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('ticket.show', $att->ticket_code) }}" target="_blank"
                                        class="btn btn-outline btn-sm">
                                        <i class="fas fa-ticket-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($event->attendees->count() > 20)
                <div style="padding:1rem;text-align:center;border-top:1px solid var(--border)">
                    <a href="{{ route('admin.attendees.index') }}?event_id={{ $event->id }}" class="btn btn-outline btn-sm">
                        Lihat semua {{ $event->attendees->count() }} peserta →
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection