@extends('layouts.admin')
@section('title', 'Profil Akun')
@section('page-title', 'Profil Akun')
@section('breadcrumb', 'Admin / Profil')

@section('content')
    <div class="grid" style="grid-template-columns:300px 1fr;gap:1.25rem;align-items:start;max-width:800px">

        {{-- LEFT: Profile Card --}}
        <div>
            <div class="card" style="text-align:center">
                <div class="card-body" style="padding:2rem 1.5rem">
                    {{-- Avatar --}}
                    <div style="
                            width:80px;height:80px;
                            background:linear-gradient(135deg,#6C63FF,#a78bfa);
                            border-radius:50%;
                            display:flex;align-items:center;justify-content:center;
                            font-size:2rem;font-weight:800;color:#fff;
                            margin:0 auto 1.25rem;
                            box-shadow:0 6px 20px rgba(108,99,255,.3);
                        ">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <div style="font-size:1.1rem;font-weight:800;color:var(--text);margin-bottom:.25rem">
                        {{ auth()->user()->name }}
                    </div>
                    <div class="text-muted text-sm mb-2">{{ auth()->user()->email }}</div>
                    <span class="badge badge-purple" style="font-size:.78rem;padding:.35rem .875rem">
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                </div>

                <div style="border-top:1px solid var(--border);padding:1rem 1.5rem;background:var(--surface-2)">
                    <div class="d-flex justify-between text-sm mb-1">
                        <span class="text-muted">Bergabung sejak</span>
                        <span style="color:var(--text);font-weight:600">
                            {{ auth()->user()->created_at->format('d M Y') }}
                        </span>
                    </div>
                    <div class="d-flex justify-between text-sm">
                        <span class="text-muted">Role</span>
                        <span style="color:var(--primary);font-weight:700">
                            {{ ucfirst(auth()->user()->role) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Security tips --}}
            <div class="card mt-2" style="border-left:3px solid var(--primary)">
                <div class="card-body">
                    <div style="font-weight:700;color:var(--text);margin-bottom:.75rem;font-size:.875rem">
                        🔒 Tips Keamanan
                    </div>
                    <ul style="font-size:.8rem;color:var(--text-muted);padding-left:1.25rem;line-height:1.8">
                        <li>Gunakan minimal 8 karakter</li>
                        <li>Kombinasikan huruf besar & kecil</li>
                        <li>Tambahkan angka atau simbol</li>
                        <li>Jangan gunakan password yang sama di platform lain</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- RIGHT: Change Password Form --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">🔑 Ganti Password</span>
            </div>
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>
                    </div>
                @endif

                <form action="{{ route('admin.profile.password') }}" method="POST" id="changePasswordForm">
                    @csrf

                    {{-- Current Password --}}
                    <div class="form-group">
                        <label class="form-label">Password Saat Ini *</label>
                        <div style="position:relative">
                            <input type="password" name="current_password" id="current_password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                placeholder="Masukkan password saat ini" autocomplete="current-password" required
                                style="padding-right:2.5rem">
                            <button type="button" onclick="togglePw('current_password','eye1')"
                                style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-muted)">
                                <i class="fas fa-eye" id="eye1"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <div style="color:var(--danger);font-size:.78rem;margin-top:.3rem">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Divider --}}
                    <div style="border-top:1px dashed var(--border);margin:1.25rem 0"></div>

                    {{-- New Password --}}
                    <div class="form-group">
                        <label class="form-label">Password Baru *</label>
                        <div style="position:relative">
                            <input type="password" name="password" id="new_password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Minimal 6 karakter" autocomplete="new-password" required
                                oninput="checkStrength(this.value)" style="padding-right:2.5rem">
                            <button type="button" onclick="togglePw('new_password','eye2')"
                                style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-muted)">
                                <i class="fas fa-eye" id="eye2"></i>
                            </button>
                        </div>
                        @error('password')
                            <div style="color:var(--danger);font-size:.78rem;margin-top:.3rem">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror

                        {{-- Strength bar --}}
                        <div style="margin-top:.5rem">
                            <div style="background:var(--border);border-radius:4px;height:5px;overflow:hidden">
                                <div id="strengthBar"
                                    style="height:100%;width:0%;border-radius:4px;transition:width .3s,background .3s">
                                </div>
                            </div>
                            <div id="strengthLabel" style="font-size:.72rem;color:var(--text-muted);margin-top:.25rem">
                            </div>
                        </div>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password Baru *</label>
                        <div style="position:relative">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" placeholder="Ulangi password baru" autocomplete="new-password" required
                                oninput="checkMatch()" style="padding-right:2.5rem">
                            <button type="button" onclick="togglePw('password_confirmation','eye3')"
                                style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-muted)">
                                <i class="fas fa-eye" id="eye3"></i>
                            </button>
                        </div>
                        <div id="matchMsg" style="font-size:.72rem;margin-top:.25rem"></div>
                    </div>

                    {{-- Requirements checklist --}}
                    <div
                        style="background:var(--bg);border:1px solid var(--border);border-radius:10px;padding:1rem;margin-bottom:1.25rem">
                        <div style="font-size:.78rem;font-weight:700;color:var(--text-secondary);margin-bottom:.625rem">
                            Persyaratan password:</div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.3rem">
                            <div class="req-item" id="req-length" style="font-size:.76rem;color:var(--text-muted)">○ Minimal
                                6 karakter</div>
                            <div class="req-item" id="req-upper" style="font-size:.76rem;color:var(--text-muted)">○ Huruf
                                kapital (A-Z)</div>
                            <div class="req-item" id="req-number" style="font-size:.76rem;color:var(--text-muted)">○
                                Mengandung angka</div>
                            <div class="req-item" id="req-symbol" style="font-size:.76rem;color:var(--text-muted)">○ Simbol
                                (!@#$...)</div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" disabled>
                            <i class="fas fa-key"></i> Simpan Password Baru
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline btn-lg">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Toggle show/hide password
        function togglePw(fieldId, eyeId) {
            const field = document.getElementById(fieldId);
            const eye = document.getElementById(eyeId);
            if (field.type === 'password') {
                field.type = 'text';
                eye.className = 'fas fa-eye-slash';
            } else {
                field.type = 'password';
                eye.className = 'fas fa-eye';
            }
        }

        // Password strength checker
        function checkStrength(val) {
            const bar = document.getElementById('strengthBar');
            const label = document.getElementById('strengthLabel');

            const hasLength = val.length >= 6;
            const hasUpper = /[A-Z]/.test(val);
            const hasNumber = /[0-9]/.test(val);
            const hasSymbol = /[^A-Za-z0-9]/.test(val);

            // Update requirements
            updateReq('req-length', hasLength);
            updateReq('req-upper', hasUpper);
            updateReq('req-number', hasNumber);
            updateReq('req-symbol', hasSymbol);

            const score = [hasLength, hasUpper, hasNumber, hasSymbol].filter(Boolean).length;

            const levels = [
                { pct: '0%', color: '', text: '' },
                { pct: '25%', color: '#ef4444', text: '🔴 Sangat Lemah' },
                { pct: '50%', color: '#f59e0b', text: '🟡 Lemah' },
                { pct: '75%', color: '#3b82f6', text: '🔵 Cukup Kuat' },
                { pct: '100%', color: '#10b981', text: '🟢 Kuat' },
            ];

            const level = levels[score];
            bar.style.width = level.pct;
            bar.style.background = level.color;
            label.textContent = level.text;
            label.style.color = level.color;
        }

        function updateReq(id, ok) {
            const el = document.getElementById(id);
            el.textContent = (ok ? '✅' : '○') + ' ' + el.textContent.replace(/^[✅○] /, '');
            el.style.color = ok ? '#10b981' : 'var(--text-muted)';
            el.style.fontWeight = ok ? '600' : '400';
        }

        // Confirm match checker
        function checkMatch() {
            const pw = document.getElementById('new_password').value;
            const confirm = document.getElementById('password_confirmation').value;
            const msg = document.getElementById('matchMsg');

            if (!confirm) {
                msg.textContent = '';
                return;
            }

            if (pw === confirm) {
                msg.innerHTML = '<span style="color:#10b981">✅ Password cocok</span>';
            } else {
                msg.innerHTML = '<span style="color:#ef4444">❌ Password tidak cocok</span>';
            }
        }
    </script>
@endpush