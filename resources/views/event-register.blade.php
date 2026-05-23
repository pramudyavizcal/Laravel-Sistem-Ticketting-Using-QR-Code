<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran: {{ $event->name }}</title>
    <link rel="icon" href="{{ $siteFaviconUrl }}">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary:
                {{ $event->theme_color }}
            ;
            --bg: #f8f9fe;
            --text-dark: #1e1e3a;
            --text-muted: #8b90b0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Manrope', system-ui, sans-serif;
            background: var(--bg);
            color: var(--text-dark);
            padding: 2rem 1rem;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 2rem;
            transition: 0.2s;
        }

        .back-link:hover {
            color: var(--primary);
        }

        .form-card {
            background: #fff;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        .form-header {
            background: var(--primary);
            padding: 2.5rem;
            color: #fff;
            text-align: center;
        }

        .form-header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .form-header p {
            opacity: 0.8;
            font-size: 0.9rem;
        }

        .form-body {
            padding: 2.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 700;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }

        .form-control {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid #f0f0f5;
            border-radius: 16px;
            font-family: inherit;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px
                {{ $event->theme_color }}
                15;
        }

        .btn-register {
            width: 100%;
            padding: 1.25rem;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 18px;
            font-weight: 800;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 10px 25px
                {{ $event->theme_color }}
                33;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px
                {{ $event->theme_color }}
                55;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 16px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .alert-error {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .event-info-strip {
            background: #f8f9fc;
            padding: 1.5rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .info-bit {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .info-bit strong {
            display: block;
            color: var(--text-dark);
            font-size: 0.9rem;
            margin-top: 0.2rem;
        }
    </style>
</head>

<body>

    <div class="container">
        <a href="/" class="back-link"><i class="fas fa-arrow-left"></i> Kembali ke Daftar Event</a>

        <div class="form-card">
            <div class="form-header">
                <span>{{ $event->type_icon }} {{ $event->type_label }}</span>
                <h1>Registrasi Event</h1>
                <p>{{ $event->name }}</p>
            </div>

            <div class="form-body">
                @if(session('error'))
                    <div class="alert alert-error">{{ session('error') }}</div>
                @endif

                <div class="event-info-strip">
                    <div class="info-bit">TANGGAL <strong>{{ $event->event_date->format('d M Y') }}</strong></div>
                    <div class="info-bit">WAKTU <strong>{{ substr($event->event_time, 0, 5) }} WIB</strong></div>
                    <div class="info-bit" style="grid-column: 1/-1;">LOKASI <strong>{{ $event->venue }}</strong></div>
                </div>

                <form action="{{ route('event.register', $event->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap *</label>
                        <input type="text" name="name" class="form-control" placeholder="Masukkan nama sesuai KTP"
                            value="{{ old('name') }}" required>
                    </div>

                    <div class="form-group" style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label class="form-label">Email Aktif *</label>
                            <input type="email" name="email" class="form-control" placeholder="nama@email.com"
                                value="{{ old('email') }}" required>
                        </div>
                        <div>
                            <label class="form-label">Nomor WhatsApp *</label>
                            <input type="tel" name="phone" class="form-control" placeholder="0812345..."
                                value="{{ old('phone') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jenis Tiket *</label>
                        <select name="ticket_type" class="form-control" required>
                            <option value="">-- Pilih Jenis Tiket --</option>
                            @php
                                $types = match ($event->type) {
                                    'konser' => ['VIP', 'Regular', 'VVIP'],
                                    'wisuda' => ['Wisudawan', 'Undangan'],
                                    'seminar' => ['Peserta', 'Pembicara'],
                                    default => ['Peserta'],
                                };
                            @endphp
                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ old('ticket_type') == $type ? 'selected' : '' }}>{{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Instansi / Sekolah (Opsional)</label>
                        <input type="text" name="institution" class="form-control" placeholder="Asal Instansi"
                            value="{{ old('institution') }}">
                    </div>

                    <button type="submit" class="btn-register">
                        Daftar & Ambil Tiket <i class="fas fa-chevron-right"></i>
                    </button>
                </form>
            </div>
        </div>

        <p style="text-align:center; color:var(--text-muted); font-size:0.8rem; margin-top:2rem;">&copy; {{ date('Y') }}
            QR E-Ticket System. Terjaga Keamanan Datanya.</p>
    </div>

</body>

</html>
