<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .content {
            color: #555;
        }

        .footer {
            margin-top: 30px;
            font-size: 0.8rem;
            color: #888;
            text-align: center;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #6C63FF;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 700;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Pendaftaran Diterima!</h2>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $attendee->name }}</strong>,</p>
            <p>Terima kasih telah mendaftar untuk event <strong>{{ $attendee->event->name }}</strong>.</p>
            <p>Saat ini pendaftaran Anda sedang dalam status <strong>MENUNGGU KONFIRMASI (PENDING)</strong>. Tim admin
                kami akan segera meninjau data Anda.</p>
            <p>Anda akan menerima email pemberitahuan beserta tiket digital segera setelah pendaftaran Anda disetujui.
            </p>
            <p>Harap bersabar dan cek email Anda secara berkala.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} QR E-Ticket System - Jangan membalas email ini.</p>
        </div>
    </div>
</body>

</html>