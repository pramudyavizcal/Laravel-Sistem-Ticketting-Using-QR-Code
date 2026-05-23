@extends('layouts.admin')
@section('title', 'Daftar Peserta')
@section('page-title', 'Manajemen Peserta')
@section('breadcrumb', 'Admin / Peserta')

@section('content')
    <div class="d-flex align-center justify-between mb-3">
        <div>
            <h2 style="font-size:1.5rem;font-weight:800;color:var(--text)">Daftar Peserta</h2>
            <p class="text-muted mt-1">{{ $attendees->total() }} peserta terdaftar</p>
        </div>
        <div class="d-flex gap-1">
            <a href="{{ route('admin.attendees.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Tambah Peserta
            </a>
            <button onclick="document.getElementById('importModal').style.display='flex'" class="btn btn-outline">
                <i class="fas fa-file-csv"></i> Import CSV
            </button>
        </div>
    </div>

    <!-- Filter -->
    <div class="card mb-3">
        <div class="card-body" style="padding:.875rem 1.25rem">
            <form method="GET" class="d-flex gap-2" style="flex-wrap:wrap">
                <div class="search-input-wrap" style="flex:1;min-width:200px">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" class="form-control" placeholder="Cari nama, email, kode tiket..."
                        value="{{ request('search') }}">
                </div>
                <select name="event_id" class="form-control" style="width:auto">
                    <option value="">Semua Event</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                            {{ $event->type_icon }} {{ Str::limit($event->name, 40) }}
                        </option>
                    @endforeach
                </select>
                <select name="reg_status" class="form-control" style="width:auto">
                    <option value="">Semua Status Reg</option>
                    <option value="pending" {{ request('reg_status') === 'pending' ? 'selected' : '' }}>⏳ Menunggu</option>
                    <option value="approved" {{ request('reg_status') === 'approved' ? 'selected' : '' }}>✅ Disetujui</option>
                    <option value="rejected" {{ request('reg_status') === 'rejected' ? 'selected' : '' }}>❌ Ditolak</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.attendees.index') }}" class="btn btn-outline">Reset</a>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Peserta</th>
                        <th>Event</th>
                        <th>Status Reg</th>
                        <th>Pembayaran</th>
                        <th>Check-in</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendees as $i => $att)
                        <tr>
                            <td class="text-muted text-sm">{{ $attendees->firstItem() + $i }}</td>
                            <td>
                                <div style="font-weight:600;color:var(--text)">{{ $att->name }}</div>
                                <div class="text-sm text-muted">{{ $att->email ?: '—' }}</div>
                            </td>
                            <td>
                                <div class="text-sm">{{ Str::limit($att->event?->name, 25) }}</div>
                                <span class="badge badge-info" style="font-size:.65rem">{{ $att->ticket_type }}</span>
                            </td>
                            <td>
                                @if($att->registration_status === 'approved')
                                    <span class="badge badge-success">✅ Disetujui</span>
                                @elseif($att->registration_status === 'rejected')
                                    <span class="badge badge-danger">❌ Ditolak</span>
                                @else
                                    <span class="badge badge-warning">⏳ Menunggu</span>
                                @endif
                            </td>
                            <td>
                                @if($att->payment_status === 'paid')
                                    <span class="badge badge-success">Lunas</span>
                                @elseif($att->payment_status === 'unpaid')
                                    <div style="display:flex; flex-direction:column; gap:4px">
                                        <span class="badge badge-danger">Belum Bayar</span>
                                        @if($att->payment_proof_path)
                                            <button onclick="viewProof('{{ Storage::url($att->payment_proof_path) }}')"
                                                class="btn btn-outline btn-sm" style="font-size:0.7rem; padding:2px 6px">
                                                <i class="fas fa-image"></i> Bukti Trf
                                            </button>
                                        @endif
                                    </div>
                                @else
                                    <span class="badge badge-info">FREE</span>
                                @endif
                            </td>
                            <td>
                                @if($att->is_checked_in)
                                    <span class="badge badge-success">✅ Done</span>
                                @else
                                    <span class="badge badge-warning">⏳ No</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    @if($att->registration_status === 'pending')
                                        <form action="{{ route('admin.attendees.approve', $att) }}" method="POST">
                                            @csrf
                                            <button class="btn btn-success btn-sm" title="Setujui"
                                                style="background:#10b981; border-color:#10b981">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <button class="btn btn-danger btn-sm" title="Tolak"
                                            onclick="rejectUser({{ $att->id }}, '{{ $att->name }}')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                    <a href="{{ route('admin.attendees.edit', $att) }}" class="btn btn-outline btn-sm"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center" style="padding:3rem">
                                <div style="font-size:3rem;margin-bottom:.75rem">👤</div>
                                <p style="color:var(--text-muted)">Belum ada peserta</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal"
        style="display:none;position:fixed;inset:0;z-index:1001;background:rgba(0,0,0,.7);align-items:center;justify-content:center">
        <div class="card" style="width:100%;max-width:400px;margin:1rem">
            <div class="card-header"><span class="card-title">❌ Tolak Pendaftaran</span></div>
            <div class="card-body">
                <p id="rejectText" class="mb-2"></p>
                <form id="rejectForm" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label">Alasan Penolakan</label>
                        <textarea name="reason" class="form-control" rows="3"
                            placeholder="Contoh: Kuota penuh / Data tidak valid"></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-danger">Ya, Tolak</button>
                        <button type="button" onclick="document.getElementById('rejectModal').style.display='none'"
                            class="btn btn-outline">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Proof Modal -->
    <div id="proofModal" onclick="this.style.display='none'"
        style="display:none;position:fixed;inset:0;z-index:1002;background:rgba(0,0,0,.85);align-items:center;justify-content:center;cursor:zoom-out">
        <img id="proofImg" src="" style="max-width:90%; max-height:90%; border-radius:12px; transform:scale(1)">
    </div>

    <script>
        function rejectUser(id, name) {
            document.getElementById('rejectText').innerText = 'Alasan menolak pendaftaran ' + name + ':';
            document.getElementById('rejectForm').action = '/admin/attendees/' + id + '/reject';
            document.getElementById('rejectModal').style.display = 'flex';
        }
        function viewProof(url) {
            document.getElementById('proofImg').src = url;
            document.getElementById('proofModal').style.display = 'flex';
        }
    </script>

    <div class="d-flex justify-between align-center mt-3">
        <div class="text-muted text-sm">
            Menampilkan {{ $attendees->firstItem() ?: 0 }}–{{ $attendees->lastItem() ?: 0 }} dari {{ $attendees->total() }}
        </div>
        {{ $attendees->links() }}
    </div>

    <!-- CSV Import Modal -->
    <div id="importModal"
        style="display:none;position:fixed;inset:0;z-index:1000;background:rgba(0,0,0,.7);align-items:center;justify-content:center">
        <div class="card" style="width:100%;max-width:500px;margin:1rem">
            <div class="card-header">
                <span class="card-title">📂 Import Peserta via CSV</span>
                <button onclick="document.getElementById('importModal').style.display='none'"
                    style="background:none;border:none;color:var(--text-muted);cursor:pointer;font-size:1.2rem">&times;</button>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-2">
                    <i class="fas fa-info-circle"></i>
                    Format CSV: <strong>Nama, Email, Telepon, Kursi, Jenis Tiket, Institusi, Fakultas, Jurusan</strong>
                </div>
                <form action="{{ route('admin.attendees.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Pilih Event *</label>
                        <select name="event_id" class="form-control" required>
                            <option value="">-- Pilih Event --</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                                    {{ $event->type_icon }} {{ $event->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">File CSV *</label>
                        <input type="file" name="csv_file" class="form-control" accept=".csv,.txt" required>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Import
                        </button>
                        <button type="button" onclick="document.getElementById('importModal').style.display='none'"
                            class="btn btn-outline">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection