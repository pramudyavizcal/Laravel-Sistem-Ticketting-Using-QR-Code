@extends('layouts.admin')
@section('title', 'Edit Peserta')
@section('page-title', 'Edit Peserta')
@section('breadcrumb', 'Admin / Peserta / Edit')

@section('content')
<div style="max-width:700px">
    <form action="{{ route('admin.attendees.update', $attendee) }}" method="POST">
        @csrf @method('PUT')

        <div class="card mb-3">
            <div class="card-header"><span class="card-title">🎫 Event</span></div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Event *</label>
                    <select name="event_id" class="form-control" required id="eventSelect" onchange="updateEventFields()">
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" data-type="{{ $event->type }}"
                                    {{ old('event_id', $attendee->event_id) == $event->id ? 'selected' : '' }}>
                                {{ $event->type_icon }} {{ $event->name }}
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
                    <input type="text" name="name" class="form-control" required value="{{ old('name', $attendee->name) }}">
                </div>
                <div class="form-row cols-2">
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $attendee->email) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $attendee->phone) }}">
                    </div>
                </div>
                <div class="form-row cols-2">
                    <div class="form-group">
                        <label class="form-label">Jenis Tiket *</label>
                        <select name="ticket_type" class="form-control" required>
                            @foreach(['Regular','VIP','VVIP','Peserta','Panitia','Pembicara','Wisudawan','Undangan','Mentor'] as $t)
                            <option value="{{ $t }}" {{ old('ticket_type', $attendee->ticket_type) === $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor Kursi</label>
                        <input type="text" name="seat_number" class="form-control" value="{{ old('seat_number', $attendee->seat_number) }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Institusi</label>
                    <input type="text" name="institution" class="form-control" value="{{ old('institution', $attendee->institution) }}">
                </div>
                <div id="wisudaFields">
                    <div class="form-row cols-2">
                        <div class="form-group">
                            <label class="form-label">Fakultas</label>
                            <input type="text" name="faculty" class="form-control" value="{{ old('faculty', $attendee->faculty) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Program Studi</label>
                            <input type="text" name="major" class="form-control" value="{{ old('major', $attendee->major) }}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes', $attendee->notes) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Ticket Code (readonly) -->
        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label">Kode Tiket (tidak dapat diubah)</label>
                <input type="text" class="form-control" value="{{ $attendee->ticket_code }}" readonly
                       style="font-family:monospace;opacity:.6">
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i> Update Peserta
            </button>
            <a href="{{ route('admin.attendees.show', $attendee) }}" class="btn btn-outline btn-lg">Batal</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function updateEventFields() {
    const sel  = document.getElementById('eventSelect');
    const opt  = sel.options[sel.selectedIndex];
    const type = opt ? opt.dataset.type : '';
    document.getElementById('wisudaFields').style.display = type === 'wisuda' ? 'block' : 'none';
}
document.addEventListener('DOMContentLoaded', updateEventFields);
</script>
@endpush
