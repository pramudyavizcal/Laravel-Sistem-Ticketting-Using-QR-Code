@extends('layouts.admin')
@section('title', 'Tambah Peserta')
@section('page-title', 'Tambah Peserta')
@section('breadcrumb', 'Admin / Peserta / Tambah')

@section('content')
<div style="max-width:700px">
    <form action="{{ route('admin.attendees.store') }}" method="POST">
        @csrf

        <div class="card mb-3">
            <div class="card-header"><span class="card-title">🎫 Event</span></div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Pilih Event *</label>
                    <select name="event_id" class="form-control" required id="eventSelect" onchange="updateEventFields()">
                        <option value="">-- Pilih Event --</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}"
                                    data-type="{{ $event->type }}"
                                    {{ (old('event_id', $selectedEvent?->id) == $event->id) ? 'selected' : '' }}>
                                {{ $event->type_icon }} {{ $event->name }} ({{ $event->event_date->format('d M Y') }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header"><span class="card-title">👤 Data Peserta</span></div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap *</label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name') }}" placeholder="Nama lengkap peserta">
                </div>
                <div class="form-row cols-2">
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="email@contoh.com">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor HP</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="08xx-xxxx-xxxx">
                    </div>
                </div>
                <div class="form-row cols-2">
                    <div class="form-group">
                        <label class="form-label">Jenis Tiket *</label>
                        <select name="ticket_type" class="form-control" required id="ticketTypeSelect">
                            <option value="Regular" {{ old('ticket_type') === 'Regular' ? 'selected' : '' }}>Regular</option>
                            <option value="VIP"     {{ old('ticket_type') === 'VIP'     ? 'selected' : '' }}>VIP</option>
                            <option value="VVIP"    {{ old('ticket_type') === 'VVIP'    ? 'selected' : '' }}>VVIP</option>
                            <option value="Peserta" {{ old('ticket_type') === 'Peserta' ? 'selected' : '' }}>Peserta</option>
                            <option value="Panitia" {{ old('ticket_type') === 'Panitia' ? 'selected' : '' }}>Panitia</option>
                            <option value="Pembicara" {{ old('ticket_type') === 'Pembicara' ? 'selected' : '' }}>Pembicara</option>
                            <option value="Wisudawan" {{ old('ticket_type') === 'Wisudawan' ? 'selected' : '' }}>Wisudawan</option>
                            <option value="Undangan" {{ old('ticket_type') === 'Undangan' ? 'selected' : '' }}>Undangan</option>
                            <option value="Mentor"  {{ old('ticket_type') === 'Mentor'  ? 'selected' : '' }}>Mentor</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor Kursi</label>
                        <input type="text" name="seat_number" class="form-control" value="{{ old('seat_number') }}" placeholder="A-001">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Institusi / Perusahaan</label>
                    <input type="text" name="institution" class="form-control" value="{{ old('institution') }}" placeholder="Universitas / Perusahaan">
                </div>

                <!-- Wisuda-specific fields -->
                <div id="wisudaFields" style="display:none">
                    <div class="form-row cols-2">
                        <div class="form-group">
                            <label class="form-label">Fakultas</label>
                            <input type="text" name="faculty" class="form-control" value="{{ old('faculty') }}" placeholder="Teknik, Ekonomi, ...">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Program Studi</label>
                            <input type="text" name="major" class="form-control" value="{{ old('major') }}" placeholder="Informatika, Manajemen, ...">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" class="form-control" rows="2" placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-user-plus"></i> Simpan Peserta
            </button>
            <a href="{{ route('admin.attendees.index') }}" class="btn btn-outline btn-lg">Batal</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function updateEventFields() {
    const sel   = document.getElementById('eventSelect');
    const opt   = sel.options[sel.selectedIndex];
    const type  = opt ? opt.dataset.type : '';
    document.getElementById('wisudaFields').style.display = type === 'wisuda' ? 'block' : 'none';
}
document.addEventListener('DOMContentLoaded', updateEventFields);
</script>
@endpush
