@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Selamat datang, ' . auth()->user()->name)

@section('content')
    <!-- Stats Grid -->
    <div class="grid grid-4 mb-3">
        <div class="stat-card purple">
            <div class="stat-icon" style="background:rgba(108,99,255,.15)">🎪</div>
            <div class="stat-value">{{ $stats['total_events'] }}</div>
            <div class="stat-label">Total Event</div>
            <div class="stat-sub">{{ $stats['active_events'] }} aktif</div>
        </div>
        <div class="stat-card cyan">
            <div class="stat-icon" style="background:rgba(0,201,255,.15)">👥</div>
            <div class="stat-value">{{ number_format($stats['total_attendees']) }}</div>
            <div class="stat-label">Total Peserta</div>
            <div class="stat-sub">terdaftar di semua event</div>
        </div>
        <div class="stat-card green">
            <div class="stat-icon" style="background:rgba(67,233,123,.15)">✅</div>
            <div class="stat-value">{{ number_format($stats['checked_in']) }}</div>
            <div class="stat-label">Sudah Check-in</div>
            <div class="stat-sub">
                @if($stats['total_attendees'] > 0)
                    {{ round($stats['checked_in'] / $stats['total_attendees'] * 100) }}% dari total
                @else
                    0%
                @endif
            </div>
        </div>
        <a href="{{ route('admin.attendees.index', ['reg_status' => 'pending']) }}" class="stat-card orange"
            style="text-decoration:none">
            <div class="stat-icon" style="background:rgba(245,158,11,.15)">⏳</div>
            <div class="stat-value">{{ number_format($stats['pending_registrations']) }}</div>
            <div class="stat-label">Butuh Approval</div>
            <div class="stat-sub">Pendaftaran baru</div>
        </a>
    </div>

    @if($stats['pending_registrations'] > 0)
        <div class="card mb-3" style="background:rgba(245,158,11,0.05); border:1px solid rgba(245,158,11,0.2)">
            <div class="card-body d-flex justify-between align-center" style="padding:1rem 1.5rem">
                <div class="d-flex align-center gap-1">
                    <span style="font-size:1.5rem">🔔</span>
                    <div>
                        <div style="font-weight:700; color:var(--text)">Ada pendaftaran baru!</div>
                        <div class="text-sm text-muted">Terdapat {{ $stats['pending_registrations'] }} pendaftaran yang perlu
                            ditinjau.</div>
                    </div>
                </div>
                <a href="{{ route('admin.attendees.index', ['reg_status' => 'pending']) }}"
                    class="btn btn-primary btn-sm">Proses Sekarang</a>
            </div>
        </div>
    @endif

    <div class="grid grid-2 mb-3" style="grid-template-columns: 2fr 1fr;">
        <!-- Event Stats Table -->
        <div class="card">
            <div class="card-header">
                <span class="card-title">📊 Status per Event</span>
                <a href="{{ route('admin.events.index') }}" class="btn btn-outline btn-sm">Lihat Semua</a>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Tipe</th>
                            <th>Peserta</th>
                            <th>Check-in</th>
                            <th>Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($eventStats as $event)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.events.show', $event) }}"
                                        style="color:var(--text);text-decoration:none;font-weight:600;">
                                        {{ Str::limit($event->name, 35) }}
                                    </a>
                                    <div class="text-muted text-sm">{{ $event->venue }}</div>
                                </td>
                                <td>
                                    <span class="type-chip type-{{ $event->type }}">
                                        {{ $event->type_icon }} {{ $event->type_label }}
                                    </span>
                                </td>
                                <td style="font-weight:700">{{ $event->attendees_count }}</td>
                                <td>
                                    <span style="color:var(--success);font-weight:700">{{ $event->checked_in_count }}</span>
                                </td>
                                <td style="min-width:100px">
                                    @php $pct = $event->attendees_count > 0 ? round($event->checked_in_count / $event->attendees_count * 100) : 0; @endphp
                                    <div style="background:var(--border);border-radius:4px;height:6px;overflow:hidden">
                                        <div
                                            style="height:100%;width:{{ $pct }}%;background:linear-gradient(90deg,var(--success),#6ee7b7);border-radius:4px;transition:width .5s">
                                        </div>
                                    </div>
                                    <div class="text-sm" style="color:var(--text-muted);margin-top:.2rem">{{ $pct }}%</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted" style="padding:2rem">Belum ada event</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Event by Type -->
        <div class="card">
            <div class="card-header">
                <span class="card-title">🎯 Event per Tipe</span>
            </div>
            <div class="card-body">
                @php
                    $types = [
                        'wisuda' => ['icon' => '🎓', 'label' => 'Wisuda', 'cls' => 'purple'],
                        'seminar' => ['icon' => '📚', 'label' => 'Seminar', 'cls' => 'cyan'],
                        'konser' => ['icon' => '🎵', 'label' => 'Konser', 'cls' => 'red'],
                        'workshop' => ['icon' => '🔧', 'label' => 'Workshop', 'cls' => 'green'],
                    ];
                @endphp
                @foreach($types as $key => $meta)
                    @php $count = $eventsByType[$key]->count ?? 0; @endphp
                    <div
                        style="display:flex;align-items:center;gap:.75rem;padding:.75rem 0;border-bottom:1px solid var(--border);">
                        <div
                            style="width:40px;height:40px;border-radius:10px;background:var(--bg-2);display:flex;align-items:center;justify-content:center;font-size:1.2rem">
                            {{ $meta['icon'] }}
                        </div>
                        <div style="flex:1">
                            <div style="font-weight:600;color:var(--text);font-size:.85rem">{{ $meta['label'] }}</div>
                            <div style="font-size:.75rem;color:var(--text-muted)">{{ $count }} event</div>
                        </div>
                        <div style="font-size:1.3rem;font-weight:800;color:var(--text)">{{ $count }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Scans -->
    <div class="card">
        <div class="card-header">
            <span class="card-title">📡 Aktivitas Scan Terbaru</span>
            <a href="{{ route('admin.scan-logs') }}" class="btn btn-outline btn-sm">Lihat Semua</a>
        </div>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Peserta</th>
                        <th>Event</th>
                        <th>Hasil</th>
                        <th>Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentScans as $log)
                        <tr>
                            <td class="text-sm" style="color:var(--text-muted)">
                                {{ $log->created_at->diffForHumans() }}
                            </td>
                            <td style="font-weight:600">
                                {{ $log->attendee?->name ?? '—' }}
                            </td>
                            <td class="text-sm" style="color:var(--text-muted)">
                                {{ $log->event?->name ? Str::limit($log->event->name, 30) : '—' }}
                            </td>
                            <td>
                                @if($log->result === 'success')
                                    <span class="badge badge-success">✅ Berhasil</span>
                                @elseif($log->result === 'duplicate')
                                    <span class="badge badge-warning">⚠️ Duplikat</span>
                                @else
                                    <span class="badge badge-danger">❌ Invalid</span>
                                @endif
                            </td>
                            <td class="text-sm" style="color:var(--text-muted)">{{ $log->scanned_by ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted" style="padding:2rem">Belum ada aktivitas scan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-4 mt-3">
        <a href="{{ route('admin.events.create') }}" class="card"
            style="text-decoration:none;padding:1.25rem;display:flex;align-items:center;gap:.875rem;transition:transform .2s,box-shadow .2s"
            onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform=''">
            <div
                style="width:44px;height:44px;background:rgba(108,99,255,.15);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.3rem">
                ➕</div>
            <div>
                <div style="font-weight:700;color:var(--text)">Buat Event</div>
                <div class="text-sm text-muted">Event baru</div>
            </div>
        </a>
        <a href="{{ route('admin.attendees.create') }}" class="card"
            style="text-decoration:none;padding:1.25rem;display:flex;align-items:center;gap:.875rem;transition:transform .2s"
            onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform=''">
            <div
                style="width:44px;height:44px;background:rgba(0,201,255,.15);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.3rem">
                👤</div>
            <div>
                <div style="font-weight:700;color:var(--text)">Tambah Peserta</div>
                <div class="text-sm text-muted">Daftar manual</div>
            </div>
        </a>
        <a href="{{ route('admin.scanner') }}" class="card"
            style="text-decoration:none;padding:1.25rem;display:flex;align-items:center;gap:.875rem;transition:transform .2s"
            onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform=''">
            <div
                style="width:44px;height:44px;background:rgba(67,233,123,.15);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.3rem">
                📷</div>
            <div>
                <div style="font-weight:700;color:var(--text)">QR Scanner</div>
                <div class="text-sm text-muted">Scan tiket</div>
            </div>
        </a>
        <a href="{{ route('admin.scan-logs') }}" class="card"
            style="text-decoration:none;padding:1.25rem;display:flex;align-items:center;gap:.875rem;transition:transform .2s"
            onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform=''">
            <div
                style="width:44px;height:44px;background:rgba(245,158,11,.15);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.3rem">
                📋</div>
            <div>
                <div style="font-weight:700;color:var(--text)">Log Scan</div>
                <div class="text-sm text-muted">Riwayat scan</div>
            </div>
        </a>
    </div>
@endsection