@extends('layouts.admin')
@section('title', 'Detail Peserta')
@section('page-title', 'Detail Peserta')
@section('breadcrumb', 'Admin / Peserta / Detail')

@section('content')
    <div class="grid" style="grid-template-columns:340px 1fr;gap:1rem;align-items:start">
        <!-- Left: Ticket Preview -->
        <div>
            <div class="card mb-2" style="border-top:4px solid {{ $attendee->event?->theme_color ?? '#6C63FF' }}">
                <div class="card-body text-center">
                    <div style="font-size:2.5rem;margin-bottom:.5rem">{{ $attendee->event?->type_icon ?? '🎫' }}</div>
                    <div
                        style="font-size:.75rem;font-weight:700;color:var(--text-muted);letter-spacing:.1em;text-transform:uppercase;margin-bottom:.25rem">
                        {{ $attendee->event?->type_label }}
                    </div>
                    <h2 style="font-weight:800;font-size:1.1rem;color:var(--text);margin-bottom:1rem">{{ $attendee->name }}</h2>

                    <!-- QR Preview -->
                    <div style="background:#fff;border-radius:12px;padding:1rem;display:inline-block;margin-bottom:1rem">
                        <img src="{{ route('ticket.show', $attendee->ticket_code) }}" onerror="this.style.display='none'"
                            style="display:none">
                        <div
                            style="color:#000;font-size:.6rem;word-break:break-all;max-width:160px;text-align:center;padding:.5rem;font-family:monospace">
                            {{ $attendee->ticket_code }}
                        </div>
                    </div>

                    <div style="border-top:1px dashed var(--border);padding-top:1rem">
                        <div class="d-flex justify-between text-sm mb-1">
                            <span class="text-muted">Jenis Tiket</span>
                            <span style="font-weight:700;color:var(--text)">{{ $attendee->ticket_type }}</span>
                        </div>
                        @if($attendee->seat_number)
                            <div class="d-flex justify-between text-sm mb-1">
                                <span class="text-muted">Kursi</span>
                                <span style="font-weight:700;color:var(--text)">{{ $attendee->seat_number }}</span>
                            </div>
                        @endif
                        <div class="d-flex justify-between text-sm mb-1">
                            <span class="text-muted">Status</span>
                            @if($attendee->is_checked_in)
                                <span class="badge badge-success">✅ Check-in</span>
                            @else
                                <span class="badge badge-warning">⏳ Belum</span>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('ticket.show', $attendee->ticket_code) }}" target="_blank"
                        class="btn btn-primary btn-sm" style="width:100%;margin-top:.75rem">
                        <i class="fas fa-external-link-alt"></i> Lihat Tiket Digital
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div style="font-weight:700;margin-bottom:.75rem;color:var(--text)">Tindakan</div>
                    <div style="display:flex;flex-direction:column;gap:.5rem">
                        <a href="{{ route('admin.attendees.edit', $attendee) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit Peserta
                        </a>
                        @if($attendee->is_checked_in)
                            <form action="{{ route('admin.attendees.reset-checkin', $attendee) }}" method="POST"
                                onsubmit="return confirm('Reset status check-in peserta ini?')">
                                @csrf
                                <button class="btn btn-warning btn-sm" style="width:100%">
                                    <i class="fas fa-undo"></i> Reset Check-in
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('admin.attendees.destroy', $attendee) }}" method="POST"
                            onsubmit="return confirm('Hapus peserta ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" style="width:100%">
                                <i class="fas fa-trash"></i> Hapus Peserta
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Info & Logs -->
        <div>
            <div class="card mb-3">
                <div class="card-header"><span class="card-title">👤 Informasi Peserta</span></div>
                <div class="card-body">
                    <div class="grid grid-2" style="gap:.75rem">
                        <div>
                            <div class="text-muted text-sm mb-1">Nama Lengkap</div>
                            <div style="font-weight:600;color:var(--text)">{{ $attendee->name }}</div>
                        </div>
                        <div>
                            <div class="text-muted text-sm mb-1">Event</div>
                            <div style="font-weight:600;color:var(--text)">{{ $attendee->event?->name }}</div>
                        </div>
                        <div>
                            <div class="text-muted text-sm mb-1">Email</div>
                            <div>{{ $attendee->email ?: '—' }}</div>
                        </div>
                        <div>
                            <div class="text-muted text-sm mb-1">Telepon</div>
                            <div>{{ $attendee->phone ?: '—' }}</div>
                        </div>
                        <div>
                            <div class="text-muted text-sm mb-1">Jenis Tiket</div>
                            <span class="badge badge-info">{{ $attendee->ticket_type }}</span>
                        </div>
                        <div>
                            <div class="text-muted text-sm mb-1">Nomor Kursi</div>
                            <div>{{ $attendee->seat_number ?: '—' }}</div>
                        </div>
                        @if($attendee->institution)
                            <div>
                                <div class="text-muted text-sm mb-1">Institusi</div>
                                <div>{{ $attendee->institution }}</div>
                            </div>
                        @endif
                        @if($attendee->faculty)
                            <div>
                                <div class="text-muted text-sm mb-1">Fakultas</div>
                                <div>{{ $attendee->faculty }}</div>
                            </div>
                            <div>
                                <div class="text-muted text-sm mb-1">Program Studi</div>
                                <div>{{ $attendee->major ?: '—' }}</div>
                            </div>
                        @endif
                        @if($attendee->is_checked_in)
                            <div>
                                <div class="text-muted text-sm mb-1">Check-in Pada</div>
                                <div style="color:var(--success)">{{ $attendee->checked_in_at?->format('d M Y, H:i') }}</div>
                            </div>
                            <div>
                                <div class="text-muted text-sm mb-1">Di-scan Oleh</div>
                                <div>{{ $attendee->checked_in_by }}</div>
                            </div>
                        @endif
                    </div>
                    @if($attendee->notes)
                        <div style="margin-top:1rem;padding-top:1rem;border-top:1px solid var(--border)">
                            <div class="text-muted text-sm mb-1">Catatan</div>
                            <p style="font-size:.875rem">{{ $attendee->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Scan History -->
            <div class="card">
                <div class="card-header">
                    <span class="card-title">📡 Riwayat Scan</span>
                    <span class="text-muted text-sm">{{ $attendee->scanLogs->count() }} scan</span>
                </div>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Hasil</th>
                                <th>Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendee->scanLogs as $log)
                                <tr>
                                    <td class="text-sm text-muted">{{ $log->created_at->format('d M Y, H:i:s') }}</td>
                                    <td>
                                        @if($log->result === 'success')
                                            <span class="badge badge-success">✅ Berhasil</span>
                                        @elseif($log->result === 'duplicate')
                                            <span class="badge badge-warning">⚠️ Duplikat</span>
                                        @else
                                            <span class="badge badge-danger">❌ Invalid</span>
                                        @endif
                                    </td>
                                    <td class="text-sm">{{ $log->scanned_by ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted" style="padding:1.5rem">Belum ada riwayat scan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection