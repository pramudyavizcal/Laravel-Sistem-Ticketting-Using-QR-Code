<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selesai Pendaftaran</title>
    <link rel="icon" href="{{ $siteFaviconUrl }}">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #6C63FF;
            --bg: #f8f9fe;
            --text-dark: #1e1e3a;
            --text-muted: #8b90b0;
        }

        body {
            font-family: 'Manrope', system-ui, sans-serif;
            background: var(--bg);
            color: var(--text-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .card {
            background: #fff;
            padding: 3rem;
            border-radius: 32px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
            text-align: center;
            max-width: 500px;
            width: 100%;
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        .icon {
            width: 80px;
            height: 80px;
            background: #f0f0ff;
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1.5rem;
        }

        h1 {
            font-size: 1.75rem;
            font-weight: 800;
            margin-bottom: 1rem;
            letter-spacing: -0.5px;
        }

        p {
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .info-box {
            background: #f8f9fb;
            padding: 1.25rem;
            border-radius: 18px;
            text-align: left;
            margin-bottom: 2rem;
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        .info-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-weight: 700;
            color: var(--text-dark);
        }

        .btn {
            display: block;
            width: 100%;
            padding: 1.15rem;
            background: var(--primary);
            color: #fff;
            text-decoration: none;
            border-radius: 16px;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(108, 99, 255, 0.2);
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="icon"><i class="fas fa-hourglass-half"></i></div>
        <h1>Pendaftaran Terkirim!</h1>
        <p>Terima kasih telah mendaftar. Pendaftaran Anda sedang menunggu konfirmasi dari Admin.</p>

        <div class="info-box">
            <div class="info-label">Nama Pendaftar</div>
            <div class="info-value">{{ $attendee->name }}</div>
            <div style="margin-top:1rem"></div>
            <div class="info-label">Event</div>
            <div class="info-value">{{ $attendee->event->name }}</div>
        </div>

        <p style="font-size:0.85rem; margin-bottom:1.5rem">Kami akan mengirimkan tiket digital ke email
            <strong>{{ $attendee->email }}</strong> setelah pendaftaran disetujui.</p>

        <a href="/" class="btn">Kembali ke Beranda</a>
    </div>
</body>

</html>
