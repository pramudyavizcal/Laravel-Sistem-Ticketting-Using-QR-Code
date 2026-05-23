<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — {{ $siteName }} System</title>
    <link rel="icon" href="{{ $siteFaviconUrl }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #f4f6fb;
            position: relative;
            overflow: hidden;
        }

        /* ─── DECORATIVE LEFT PANEL ─── */
        .left-panel {
            flex: 1;
            background: linear-gradient(145deg, #6C63FF 0%, #8b5cf6 50%, #a78bfa 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, .08);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, .06);
            border-radius: 50%;
            bottom: -50px;
            left: -80px;
        }

        .left-content {
            position: relative;
            z-index: 1;
            color: #fff;
            text-align: center;
            max-width: 380px;
        }

        .left-icon {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            filter: drop-shadow(0 8px 24px rgba(0, 0, 0, .2));
        }

        .left-title {
            font-size: 2.2rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .left-desc {
            font-size: .95rem;
            color: rgba(255, 255, 255, .8);
            line-height: 1.7;
            margin-bottom: 2rem;
        }

        /* Event type pills */
        .event-pills {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
            justify-content: center;
        }

        .event-pill {
            background: rgba(255, 255, 255, .15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: 20px;
            padding: .3rem .9rem;
            font-size: .8rem;
            font-weight: 600;
            color: #fff;
        }

        /* ─── RIGHT PANEL (LOGIN FORM) ─── */
        .right-panel {
            width: 460px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem;
            background: #fff;
            box-shadow: -4px 0 40px rgba(0, 0, 0, .06);
        }

        .login-box {
            width: 100%;
            max-width: 380px;
        }

        .login-logo {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: 2.5rem;
        }

        .logo-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #6C63FF, #a78bfa);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            box-shadow: 0 4px 14px rgba(108, 99, 255, .35);
        }

        .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 12px;
        }

        .logo-text {
            font-size: 1.1rem;
            font-weight: 800;
            color: #1e1e3a;
        }

        .logo-sub {
            font-size: .72rem;
            color: #8b90b0;
        }

        .login-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: #1e1e3a;
            margin-bottom: .4rem;
        }

        .login-subtitle {
            font-size: .875rem;
            color: #8b90b0;
            margin-bottom: 2rem;
        }

        /* Error alert */
        .alert-error {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
            border-radius: 8px;
            padding: .75rem 1rem;
            font-size: .82rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        /* Form */
        .form-group {
            margin-bottom: 1.1rem;
        }

        .form-label {
            display: block;
            font-size: .8rem;
            font-weight: 600;
            color: #4b5070;
            margin-bottom: .4rem;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: .9rem;
            top: 50%;
            transform: translateY(-50%);
            color: #8b90b0;
            font-size: .85rem;
        }

        .form-input {
            width: 100%;
            padding: .7rem .875rem .7rem 2.4rem;
            border: 1.5px solid #e5e7f0;
            border-radius: 10px;
            font-size: .9rem;
            color: #1e1e3a;
            background: #f8f9fc;
            font-family: 'Inter', sans-serif;
            transition: all .15s;
        }

        .form-input:focus {
            outline: none;
            border-color: #6C63FF;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(108, 99, 255, .12);
        }

        .form-input::placeholder {
            color: #b0b5cc;
        }

        /* Toggle password */
        .toggle-pw {
            position: absolute;
            right: .9rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #8b90b0;
            font-size: .85rem;
            transition: color .15s;
        }

        .toggle-pw:hover {
            color: #6C63FF;
        }

        /* Submit */
        .btn-login {
            width: 100%;
            padding: .85rem;
            background: linear-gradient(135deg, #6C63FF, #8b5cf6);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: .95rem;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all .2s;
            box-shadow: 0 4px 14px rgba(108, 99, 255, .35);
            margin-top: .5rem;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(108, 99, 255, .45);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Credentials hint */
        .credentials-hint {
            margin-top: 1.5rem;
            background: #f4f6fb;
            border: 1px solid #e5e7f0;
            border-radius: 10px;
            padding: .875rem;
            font-size: .76rem;
        }

        .credentials-hint .ch-title {
            font-weight: 700;
            color: #4b5070;
            margin-bottom: .5rem;
            display: flex;
            align-items: center;
            gap: .4rem;
        }

        .ch-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: .25rem 0;
            border-bottom: 1px solid #eef0f8;
        }

        .ch-row:last-child {
            border-bottom: none;
        }

        .ch-lbl {
            color: #8b90b0;
        }

        .ch-val {
            font-weight: 600;
            color: #4b5070;
            font-family: monospace;
            font-size: .8rem;
        }

        /* Footer */
        .login-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: .73rem;
            color: #b0b5cc;
        }

        @media (max-width: 768px) {
            .left-panel {
                display: none;
            }

            .right-panel {
                width: 100%;
                box-shadow: none;
            }
        }
    </style>
</head>

<body>

    <!-- Left Decorative Panel -->
    <div class="left-panel">
        <div class="left-content">
            <div class="left-icon">🎫</div>
            <div class="left-title">{{ $siteName }}<br>System</div>
            <div class="left-desc">
                Platform manajemen tiket berbasis QR Code untuk berbagai jenis acara.
                Kelola peserta, scan tiket, dan pantau kehadiran secara real-time.
            </div>
            <div class="event-pills">
                <span class="event-pill">🎓 Wisuda</span>
                <span class="event-pill">📚 Seminar</span>
                <span class="event-pill">🎵 Konser</span>
                <span class="event-pill">🔧 Workshop</span>
            </div>
        </div>
    </div>

    <!-- Right Login Panel -->
    <div class="right-panel">
        <div class="login-box">

            <div class="login-logo">
                <div class="logo-icon">
                    @if($siteLogoUrl)
                        <img src="{{ $siteLogoUrl }}" alt="{{ $siteName }}">
                    @else
                        🎫
                    @endif
                </div>
                <div>
                    <div class="logo-text">{{ $siteName }}</div>
                    <div class="logo-sub">Admin Panel</div>
                </div>
            </div>

            <div class="login-title">Selamat Datang!</div>
            <div class="login-subtitle">Masuk ke panel admin untuk mengelola event</div>

            @if($errors->any())
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    Email atau password salah. Silakan coba lagi.
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" id="email" class="form-input" placeholder="admin@qreticket.id"
                            value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="password" class="form-input"
                            placeholder="Masukkan password" required>
                        <i class="fas fa-eye toggle-pw" id="togglePw" onclick="togglePassword()"></i>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Masuk ke Panel Admin
                </button>
            </form>

            <!-- Credentials hint -->
            <div class="credentials-hint">
                <div class="ch-title">
                    <i class="fas fa-info-circle" style="color:#6C63FF"></i>
                    Akun Demo
                </div>
                <div class="ch-row">
                    <span class="ch-lbl">Admin</span>
                    <span class="ch-val">admin@qreticket.id / admin123</span>
                </div>
                <div class="ch-row">
                    <span class="ch-lbl">Staff</span>
                    <span class="ch-val">staff@qreticket.id / staff123</span>
                </div>
            </div>

            <div class="login-footer">
                &copy; {{ date('Y') }} {{ $siteName }} System · All rights reserved
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const pw = document.getElementById('password');
            const icon = document.getElementById('togglePw');
            if (pw.type === 'password') {
                pw.type = 'text';
                icon.className = 'fas fa-eye-slash toggle-pw';
            } else {
                pw.type = 'password';
                icon.className = 'fas fa-eye toggle-pw';
            }
        }
    </script>
</body>

</html>
