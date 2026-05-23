<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Tiket: {{ $event->name }}</title>
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

        .card {
            background: #fff;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        .header {
            background: var(--primary);
            padding: 2.5rem;
            color: #fff;
            text-align: center;
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .body {
            padding: 2rem;
        }

        .price-box {
            background: #f8f9fb;
            padding: 1.5rem;
            border-radius: 20px;
            text-align: center;
            margin-bottom: 2rem;
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        .price-label {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        .price-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary);
            margin-top: 0.25rem;
        }

        .payment-method {
            margin-bottom: 2rem;
        }

        .bank-card {
            background: #fff;
            border: 2px solid #f0f0f5;
            border-radius: 20px;
            padding: 1.5rem;
            display: flex;
            gap: 1.5rem;
            align-items: center;
            margin-bottom: 1rem;
        }

        .bank-badge {
            width: 60px;
            height: 60px;
            background: var(--primary);
            color: #fff;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 800;
        }

        .bank-info h3 {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        .bank-info p {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }

        .acc-number {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background: #f0f0f5;
            padding: 0.6rem 1rem;
            border-radius: 12px;
            font-weight: 800;
            font-family: monospace;
            color: var(--text-dark);
            font-size: 1.1rem;
        }

        .copy-btn {
            color: var(--primary);
            cursor: pointer;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 700;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid #f0f0f5;
            border-radius: 16px;
            transition: 0.3s;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
        }

        .btn-submit {
            width: 100%;
            padding: 1.25rem;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 18px;
            font-weight: 800;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 10px 25px
                {{ $event->theme_color }}
                33;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .btn-submit:hover {
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
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fcd34d;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h1>Selesaikan Pembayaran</h1>
                <p>Silakan pilih metode pembayaran untuk Tiket Anda</p>
            </div>
            <div class="body">
                <div class="price-box">
                    <div class="price-label">Tagihan yang harus dibayar</div>
                    <div class="price-value">Rp {{ number_format($event->price, 0, ',', '.') }}</div>
                </div>

                @if(session('error'))
                    <div class="alert" style="background:#fee2e2; color:#b91c1c; border-color:#fecaca">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                @if($event->allow_xendit)
                    <div class="payment-method">
                        <div style="font-weight:800; margin-bottom:1rem">💳 Pembayaran Otomatis (Instan)</div>
                        <p style="font-size:0.85rem; color:var(--text-muted); margin-bottom:1rem">
                            Bayar via E-Wallet (OVO, Dana, ShopeePay), Virtual Account, atau Alfamart/Indomaret.
                            Terverifikasi otomatis oleh sistem.
                        </p>
                        <a href="{{ route('event.register.pay-xendit', $attendee->ticket_code) }}" class="btn-submit"
                            style="background:var(--text-dark); box-shadow:0 10px 25px rgba(30,30,58,0.2)">
                            Bayar Sekarang <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    @if($event->allow_manual_transfer)
                        <div
                            style="text-align:center; padding:1rem 0; color:var(--text-muted); font-size:0.8rem; font-weight:700">
                            ── ATAU ──</div>
                    @endif
                @endif

                @if($event->allow_manual_transfer)
                    <div class="payment-method">
                        <div style="font-weight:800; margin-bottom:1rem">🏦 Transfer Bank Manual</div>
                        <div class="bank-card">
                            <div class="bank-badge">{{ strtoupper(substr($event->payment_bank_name, 0, 3)) }}</div>
                            <div class="bank-info">
                                <h3>Bank {{ $event->payment_bank_name }}</h3>
                                <p>Atas Nama: <strong>{{ $event->payment_bank_holder }}</strong></p>
                                <div class="acc-number" id="accNumber">
                                    {{ $event->payment_bank_number }}
                                    <i class="far fa-copy copy-btn" title="Salin"
                                        onclick="copyToClipboard('{{ $event->payment_bank_number }}')"></i>
                                </div>
                            </div>
                        </div>

                        <div class="alert">
                            <i class="fas fa-info-circle"></i> Setelah transfer, silakan upload bukti struk/screenshot
                            pembayaran Anda di kolom bawah ini.
                        </div>

                        <form action="{{ route('event.register.submit-payment', $attendee->ticket_code) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">Upload Bukti Transfer *</label>
                                <input type="file" name="payment_proof" class="form-control" accept="image/*" required>
                                <p style="font-size:0.75rem; color:var(--text-muted); margin-top:0.5rem">Format: JPG, PNG,
                                    PDF.
                                    Maks. 5MB</p>
                            </div>

                            <button type="submit" class="btn-submit">
                                Konfirmasi Pembayaran Manual <i class="fas fa-check-circle"></i>
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
        <p style="text-align:center; color:var(--text-muted); font-size:0.8rem; margin-top:2rem;">Harap simpan bukti
            pembayaran Anda.</p>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function () {
                alert('Nomor rekening berhasil disalin!');
            }, function (err) {
                console.error('Bisa disalin secara manual: ', err);
            });
        }
    </script>
</body>

</html>
