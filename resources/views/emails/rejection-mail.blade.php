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
            color: #ef4444;
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

        .reason-box {
            background: #fef2f2;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #ef4444;
            margin: 20px 0;
            font-size: 0.95rem;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Pendaftaran Ditolak / Tidak Disetujui</h2>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $attendee->name }}</strong>,</p>
            <p>Mohon maaf, pendaftaran Anda untuk event <strong>{{ $attendee->event->name }}</strong> belum dapat kami
                setujui karena alasan berikut:</p>

            <div class="reason-box">
                <strong>Alasan Admin:</strong><br>
                {{ $attendee->admin_note ?? 'Pendaftaran tidak memenuhi kriteria atau kuota telah penuh.' }}
            </div>

            <p>Silakan hubungi tim panitia untuk informasi lebih lanjut atau pantau event kami yang lain di masa
                mendatang.</p>
            <p>Terima kasih atas ketertarikan Anda.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} QR E-Ticket System - Jangan membalas email ini.</p>
        </div>
    </div>
</body>

</html>