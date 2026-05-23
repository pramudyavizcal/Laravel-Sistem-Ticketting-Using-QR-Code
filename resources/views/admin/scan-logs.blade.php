@extends('layouts.admin')
@section('title', 'Log Scan')
@section('page-title', 'Log Scan')
@section('breadcrumb', 'Admin / Log Scan')

@section('content')
    <div class="d-flex align-center justify-between mb-3">
        <div>
            <h2 style="font-size:1.5rem;font-weight:800;color:var(--text)">Riwayat Scan</h2>
            <p class="text-muted mt-1">{{ $logs->total() }} total scan</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-3">
        <div class="card-body" style="padding:.875rem 1.25rem">
            <form method="GET" class="d-flex gap-2" style="flex-wrap:wrap">
                <select name="event_id" class="form-control" style="width:auto">
                    <option value="">Semua Event</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                            {{ $event->type_icon }} {{ Str::limit($event->name, 40) }}
                        </option>
                    @endforeach
                </select>
                <select name="result" class="form-control" style="width:auto">
                    <option value="">Semua Hasil</option>
                    <option value="success" {{ request('result') === 'success' ? 'selected' : '' }}>✅ Berhasil</option>
                    <option value="duplicate" {{ request('result') === 'duplicate' ? 'selected' : '' }}>⚠️ Duplikat</option>
                    <option value="invalid" {{ request('result') === 'invalid' ? 'selected' : '' }}>❌ Invalid</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.scan-logs') }}" class="btn btn-outline">Reset</a>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Waktu</th>
                        <th>Peserta</th>
                        <th>Event</th>
                        <th>Hasil</th>
                        <th>Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $i => $log)
                        <tr>
                            <td class="text-muted text-sm">{{ $logs->firstItem() + $i }}</td>
                            <td class="text-sm">
                                <div>{{ $log->created_at->format('d M Y') }}</div>
                                <div class="text-muted">{{ $log->created_at->format('H:i:s') }}</div>
                            </td>
                            <td>
                                @if($log->attendee)
                                    <div style="font-weight:600;color:var(--text)">{{ $log->attendee->name }}</div>
                                    <div class="text-sm text-muted">{{ $log->attendee->ticket_type }}
                                        @if($log->attendee->seat_number)· Kursi: {{ $log->attendee->seat_number }}@endif
                                    </div>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if($log->event)
                                    <div class="text-sm">{{ Str::limit($log->event->name, 35) }}</div>
                                    <span class="type-chip type-{{ $log->event->type }}"
                                        style="font-size:.65rem;padding:.1rem .4rem">
                                        {{ $log->event->type_icon }} {{ $log->event->type_label }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
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
                            <td class="text-sm text-muted">{{ $log->scanned_by ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center" style="padding:3rem">
                                <div style="font-size:3rem;margin-bottom:.75rem">📋</div>
                                <p style="color:var(--text-muted)">Belum ada log scan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-between align-center mt-3">
        <div class="text-muted text-sm">
            Menampilkan {{ $logs->firstItem() }}–{{ $logs->lastItem() }} dari {{ $logs->total() }}
        </div>
        {{ $logs->links() }}
    </div>
@endsection