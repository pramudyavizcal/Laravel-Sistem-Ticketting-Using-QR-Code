@extends('layouts.admin')
@section('title', 'Buat Event Baru')
@section('page-title', 'Buat Event Baru')
@section('breadcrumb', 'Admin / Event / Buat')

@section('content')
<div style="max-width:800px">
    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Event Type Selector -->
        <div class="card mb-3">
            <div class="card-header"><span class="card-title">🎯 Pilih Tipe Event</span></div>
            <div class="card-body">
                <div class="grid grid-4">
                    @foreach(['wisuda' => ['🎓','Wisuda','#6C63FF'], 'seminar' => ['📚','Seminar','#00C9FF'], 'konser' => ['🎵','Konser','#FF6B6B'], 'workshop' => ['🔧','Workshop','#43E97B']] as $type => [$icon, $label, $color])
                    <label class="type-selector" for="type_{{ $type }}" style="cursor:pointer">
                        <input type="radio" name="type" id="type_{{ $type }}" value="{{ $type }}"
                               {{ old('type', 'seminar') === $type ? 'checked' : '' }}
                               style="display:none" onchange="updateThemeColor('{{ $color }}')">
                        <div class="type-card" style="
                            padding:1.25rem;
                            border-radius:12px;
                            border:2px solid var(--border);
                            text-align:center;
                            transition:all .2s;
                            user-select:none;
                        " id="card_{{ $type }}">
                            <div style="font-size:2rem;margin-bottom:.5rem">{{ $icon }}</div>
                            <div style="font-weight:700;color:var(--text);font-size:.9rem">{{ $label }}</div>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Basic Info -->
        <div class="card mb-3">
            <div class="card-header"><span class="card-title">📋 Informasi Event</span></div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">Nama Event *</label>
                    <input type="text" name="name" class="form-control" required
                           placeholder="Contoh: Wisuda Sarjana Universitas XYZ 2025"
                           value="{{ old('name') }}">
                </div>
                <div class="form-row cols-2">
                    <div class="form-group">
                        <label class="form-label">Penyelenggara</label>
                        <input type="text" name="organizer" class="form-control"
                               placeholder="Nama institusi/EO" value="{{ old('organizer') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Warna Tema</label>
                        <div style="display:flex;gap:.5rem;align-items:center">
                            <input type="color" name="theme_color" id="theme_color"
                                   value="{{ old('theme_color', '#6C63FF') }}"
                                   style="width:48px;height:42px;border-radius:8px;border:1px solid var(--border);background:transparent;cursor:pointer;padding:2px">
                            <span class="text-muted text-sm">Warna aksen tiket</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3"
                              placeholder="Deskripsi singkat event...">{{ old('description') }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Venue / Lokasi *</label>
                    <input type="text" name="venue" class="form-control" required
                           placeholder="Nama gedung, kota" value="{{ old('venue') }}">
                </div>
                <div class="form-row cols-3">
                    <div class="form-group">
                        <label class="form-label">Tanggal Event *</label>
                        <input type="date" name="event_date" class="form-control" required value="{{ old('event_date') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Waktu Mulai *</label>
                        <input type="time" name="event_time" class="form-control" required value="{{ old('event_time', '08:00') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kuota Peserta *</label>
                        <input type="number" name="quota" class="form-control" required min="1"
                               placeholder="500" value="{{ old('quota') }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Media -->
        <div class="card mb-3">
            <div class="card-header"><span class="card-title">🖼️ Media (Opsional)</span></div>
            <div class="card-body">
                <div class="form-row cols-2">
                    <div class="form-group">
                        <label class="form-label">Logo Event</label>
                        <input type="file" name="logo" class="form-control" accept="image/*">
                        <div class="text-muted text-sm mt-1">JPG / PNG, maks. 2MB</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Banner Event / Slider Homepage</label>
                        <input type="file" name="banner" class="form-control" accept="image/*">
                        <div class="text-muted text-sm mt-1">Dipakai di halaman depan jika diisi. JPG / PNG, maks. 5MB</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Settings -->
        <div class="card mb-3">
            <div class="card-header"><span class="card-title">💰 Pengaturan Pembayaran</span></div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label class="form-label">Jenis Event</label>
                    <select name="is_paid" id="is_paid" class="form-control" onchange="togglePaymentFields()">
                        <option value="0" {{ old('is_paid') == '0' ? 'selected' : '' }}>Gratis (Pendaftaran Free)</option>
                        <option value="1" {{ old('is_paid') == '1' ? 'selected' : '' }}>Berbayar (Tiket Berbayar)</option>
                    </select>
                </div>

                <div id="payment-fields" style="display: {{ old('is_paid') == '1' ? 'block' : 'none' }}">
                    <div class="form-group">
                        <label class="form-label">Harga Tiket (Rp) *</label>
                        <input type="number" name="price" id="price" class="form-control" placeholder="Contoh: 50000" value="{{ old('price', 0) }}">
                    </div>

                    <div style="margin-top:1.5rem; padding-top:1rem; border-top:1px solid var(--border)">
                        <div style="font-weight:700; font-size:0.9rem; margin-bottom:1rem">Metode Pembayaran</div>
                        
                        <div class="form-check mb-2">
                            <input type="checkbox" name="allow_manual_transfer" id="allow_manual_transfer" value="1" {{ old('allow_manual_transfer', '1') ? 'checked' : '' }} onchange="toggleBankFields()">
                            <label for="allow_manual_transfer">Transfer Bank Manual</label>
                        </div>

                        <div id="bank-fields" style="display: {{ old('allow_manual_transfer', '1') ? 'block' : 'none' }}; margin-left:1.5rem; margin-bottom:1rem; padding:1rem; background:var(--bg-2); border-radius:12px">
                            <div class="form-group">
                                <label class="form-label">Nama Bank</label>
                                <input type="text" name="payment_bank_name" class="form-control" placeholder="Contoh: BCA" value="{{ old('payment_bank_name') }}">
                            </div>
                            <div class="form-row cols-2">
                                <div class="form-group">
                                    <label class="form-label">Nomor Rekening</label>
                                    <input type="text" name="payment_bank_number" class="form-control" placeholder="12345678" value="{{ old('payment_bank_number') }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Atas Nama</label>
                                    <input type="text" name="payment_bank_holder" class="form-control" placeholder="Nama Pemilik Rekening" value="{{ old('payment_bank_holder') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" name="allow_xendit" id="allow_xendit" value="1" {{ old('allow_xendit') ? 'checked' : '' }}>
                            <label for="allow_xendit">Otomatis via Xendit (E-Wallet, Virtual Account, Retail Outlet)</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_active" id="is_active" value="1"
                   {{ old('is_active', '1') ? 'checked' : '' }}>
            <label for="is_active" style="color:var(--text);font-weight:600;cursor:pointer">
                Aktifkan event (peserta bisa mendaftar)
            </label>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i> Simpan Event
            </button>
            <a href="{{ route('admin.events.index') }}" class="btn btn-outline btn-lg">Batal</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function updateThemeColor(color) {
    document.getElementById('theme_color').value = color;
    // Highlight selected type card
    document.querySelectorAll('.type-card').forEach(c => {
        c.style.border = '2px solid var(--border)';
        c.style.background = 'transparent';
    });
    const selected = document.querySelector('input[name="type"]:checked');
    if (selected) {
        const card = document.getElementById('card_' + selected.value);
        card.style.border = '2px solid ' + color;
        card.style.background = color + '22';
    }
}

// Init on page load
document.addEventListener('DOMContentLoaded', function() {
    const checked = document.querySelector('input[name="type"]:checked');
    if (checked) {
        const colors = { wisuda:'#6C63FF', seminar:'#00C9FF', konser:'#FF6B6B', workshop:'#43E97B' };
        updateThemeColor(colors[checked.value]);
    }
});

function togglePaymentFields() {
    const isPaid = document.getElementById('is_paid').value;
    document.getElementById('payment-fields').style.display = isPaid == '1' ? 'block' : 'none';
}

function toggleBankFields() {
    const allowBank = document.getElementById('allow_manual_transfer').checked;
    document.getElementById('bank-fields').style.display = allowBank ? 'block' : 'none';
}
</script>
@endpush
