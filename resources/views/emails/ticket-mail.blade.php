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
            background: #10b981;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 700;
            margin-top: 20px;
            letter-spacing: 0.05rem;
        }

        .ticket-box {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 12px;
            border: 2px dashed #ddd;
            text-align: center;
            margin: 25px 0;
        }

        .ticket-code {
            font-size: 1.5rem;
            font-weight: 800;
            color: #10b981;
            font-family: monospace;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Pendaftaran Disetujui!</h2>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $attendee->name }}</strong>,</p>
            <p>Kami memiliki kabar gembira! Pendaftaran Anda untuk event <strong>{{ $attendee->event->name }}</strong>
                telah <strong>DISETUJUI</strong> oleh tim admin kami.</p>
            <p>Dibawah ini adalah informasi tiket digital Anda:</p>

            <div class="ticket-box">
                <p style="margin-bottom: 0.5rem; color: #888; font-size: 0.8rem; text-transform: uppercase;">Kode Tiket
                </p>
                <div class="ticket-code">{{ $attendee->ticket_code }}</div>
                <p style="margin-top: 1rem; font-size: 0.9rem;">Silakan simpan kode ini atau klik tombol di bawah untuk
                    melihat tiket QR Anda.</p>
            </div>

            <div style="text-align: center;">
                <a href="{{ route('ticket.show', $attendee->ticket_code) }}" class="btn">LIHAT TIKET QR DIGITAL</a>
            </div>

            <p style="margin-top: 2rem;">Bawa tiket ini saat menghadiri event untuk diproses di meja registrasi. Sampai
                jumpa di lokasi!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} QR E-Ticket System - Jangan membalas email ini.</p>
        </div>
    </div>
</body>

</html>