<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Tiket — {{ $attendee->name }}</title>
    <link rel="icon" href="{{ $siteFaviconUrl }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
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
            background: #f0f2f8;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .ticket-wrapper {
            width: 100%;
            max-width: 420px;
        }

        /* ─── TICKET ─── */
        .ticket {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow:
                0 10px 40px rgba(0, 0, 0, .12),
                0 2px 8px rgba(0, 0, 0, .06);
        }

        /* Header */
        .ticket-header {
            background-color: {{ $attendee->event?->theme_color ?? '#6C63FF' }};
            background: linear-gradient(135deg, {{ $attendee->event?->theme_color ?? '#6C63FF' }}, {{ $attendee->event?->theme_color ?? '#5a52d5' }});
            padding: 1.875rem;
            position: relative;
            overflow: hidden;
        }

        .ticket-header::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, .08);
            border-radius: 50%;
            top: -120px;
            right: -80px;
        }

        .event-type-badge {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            background: rgba(255, 255, 255, .22);
            border: 1px solid rgba(255, 255, 255, .3);
            border-radius: 20px;
            padding: .28rem .85rem;
            font-size: .75rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: .75rem;
        }

        .event-name {
            font-size: 1.15rem;
            font-weight: 900;
            color: #fff;
            line-height: 1.3;
            margin-bottom: .25rem;
        }

        .event-organizer {
            font-size: .8rem;
            color: rgba(255, 255, 255, .8);
        }

        /* Body */
        .ticket-body {
            padding: 1.5rem 1.75rem;
        }

        /* Ticket type */
        .ticket-type-badge {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .35rem 1rem;
            border-radius: 20px;
            font-weight: 800;
            font-size: .82rem;
            border: 2px solid
                {{ $attendee->event?->theme_color ?? '#6C63FF' }}
            ;
            color:
                {{ $attendee->event?->theme_color ?? '#6C63FF' }}
            ;
            background:
                {{ $attendee->event?->theme_color ?? '#6C63FF' }}
                15;
            margin-bottom: .875rem;
        }

        /* Attendee */
        .attendee-name {
            font-size: 1.4rem;
            font-weight: 900;
            color: #1e1e3a;
            margin-bottom: .2rem;
        }

        .attendee-sub {
            font-size: .82rem;
            color: #8b90b0;
            margin-bottom: 1.15rem;
        }

        /* Info grid */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .75rem;
            margin-bottom: 1.25rem;
            background: #f4f6fb;
            border-radius: 12px;
            padding: 1rem;
        }

        .info-item label {
            font-size: .66rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #8b90b0;
            display: block;
            margin-bottom: .18rem;
        }

        .info-item span {
            font-size: .875rem;
            font-weight: 700;
            color: #1e1e3a;
        }

        /* Divider */
        .ticket-divider {
            display: flex;
            align-items: center;
            margin: 0 -1.75rem 1.25rem;
            position: relative;
        }

        .ticket-divider::before {
            content: '';
            flex: 1;
            border-top: 1.5px dashed #d1d5e8;
        }

        .ticket-divider::after {
            content: '';
            flex: 1;
            border-top: 1.5px dashed #d1d5e8;
        }

        .divider-notch {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #f0f2f8;
            flex-shrink: 0;
        }

        /* QR Section */
        .qr-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .875rem;
        }

        .qr-frame {
            background: #fff;
            border: 2px solid #e5e7f0;
            border-radius: 14px;
            padding: .875rem;
            box-shadow: 0 4px 16px rgba(0, 0, 0, .08);
        }

        .qr-frame svg {
            width: 190px;
            height: 190px;
            display: block;
        }

        .ticket-code {
            font-family: monospace;
            font-size: .7rem;
            color: #8b90b0;
            letter-spacing: .06em;
            word-break: break-all;
            text-align: center;
            background: #f4f6fb;
            padding: .35rem .75rem;
            border-radius: 6px;
            border: 1px solid #e5e7f0;
        }

        /* Status Banner */
        .status-banner {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .875rem 1.1rem;
            border-radius: 10px;
            margin-top: 1.1rem;
            font-size: .85rem;
            font-weight: 600;
        }

        .status-ok {
            background: #d1fae5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .status-pending {
            background: #ede9ff;
            border: 1px solid #c4b5fd;
            color: #4c1d95;
        }

        /* Footer */
        .ticket-footer {
            background: #f8f9fc;
            border-top: 1px solid #e5e7f0;
            padding: .875rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: .72rem;
            color: #8b90b0;
        }

        /* Print Button */
        .print-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            width: 100%;
            padding: .825rem;
            background:
                {{ $attendee->event?->theme_color ?? '#6C63FF' }}
            ;
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: .9rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 1.25rem;
            transition: all .2s;
            font-family: 'Inter', sans-serif;
            box-shadow: 0 4px 14px
                {{ $attendee->event?->theme_color ?? '#6C63FF' }}
                44;
        }

        .print-btn:hover {
            opacity: .9;
            transform: translateY(-1px);
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .print-btn {
                display: none;
            }

            .ticket {
                box-shadow: none;
                border: 1px solid #e5e7f0;
                border-radius: 12px;
            }

            .ticket-header {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .info-grid {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .status-banner {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>

    <div class="ticket-wrapper">
        <div class="ticket">
            <!-- Header -->
            <div class="ticket-header">
                <div class="event-type-badge">
                    {{ $attendee->event?->type_icon ?? '🎫' }}
                    {{ $attendee->event?->type_label ?? 'Event' }}
                </div>
                <div class="event-name">{{ $attendee->event?->name ?? 'Event' }}</div>
                @if($attendee->event?->organizer)
                    <div class="event-organizer">oleh {{ $attendee->event->organizer }}</div>
                @endif
            </div>

            <!-- Body -->
            <div class="ticket-body">

                <!-- Ticket type -->
                <div style="text-align:center;margin-bottom:1rem">
                    <div class="ticket-type-badge">
                        @if($attendee->ticket_type === 'VVIP') 👑
                        @elseif($attendee->ticket_type === 'VIP') ⭐
                        @elseif($attendee->ticket_type === 'Wisudawan') 🎓
                        @else 🎫
                        @endif
                        {{ $attendee->ticket_type }}
                    </div>
                </div>

                <!-- Attendee name -->
                <div style="text-align:center;margin-bottom:1.15rem">
                    <div class="attendee-name">{{ $attendee->name }}</div>
                    @if($attendee->institution)
                        <div class="attendee-sub">{{ $attendee->institution }}</div>
                    @endif
                    @if($attendee->faculty && $attendee->major)
                        <div class="attendee-sub" style="font-size:.78rem">
                            {{ $attendee->faculty }} · {{ $attendee->major }}
                        </div>
                    @endif
                </div>

                <!-- Event info -->
                <div class="info-grid">
                    <div class="info-item">
                        <label>📅 Tanggal</label>
                        <span>{{ $attendee->event?->event_date?->format('d M Y') ?? '—' }}</span>
                    </div>
                    <div class="info-item">
                        <label>⏰ Waktu</label>
                        <span>{{ $attendee->event?->event_time ? substr($attendee->event->event_time, 0, 5) . ' WIB' : '—' }}</span>
                    </div>
                    <div class="info-item" style="grid-column:1/-1">
                        <label>📍 Lokasi</label>
                        <span>{{ $attendee->event?->venue ?? '—' }}</span>
                    </div>
                    @if($attendee->seat_number)
                        <div class="info-item">
                            <label>💺 No. Kursi</label>
                            <span>{{ $attendee->seat_number }}</span>
                        </div>
                    @endif
                    @if($attendee->email)
                        <div class="info-item">
                            <label>📧 Email</label>
                            <span style="font-size:.76rem">{{ $attendee->email }}</span>
                        </div>
                    @endif
                </div>

                <!-- Divider -->
                <div class="ticket-divider">
                    <div class="divider-notch"></div>
                    <div class="divider-notch"></div>
                </div>

                <!-- QR Code -->
                <div class="qr-section">
                    <div class="qr-frame">
                        {!! $qrCode !!}
                    </div>
                    <div class="ticket-code">{{ $attendee->ticket_code }}</div>
                </div>

                <!-- Status -->
                @if($attendee->is_checked_in)
                    <div class="status-banner status-ok">
                        <i class="fas fa-check-circle" style="font-size:1.1rem"></i>
                        <div>
                            <div>Sudah Check-in</div>
                            <div style="font-size:.75rem;opacity:.75">{{ $attendee->checked_in_at?->format('d M Y, H:i') }}
                                WIB</div>
                        </div>
                    </div>
                @else
                    <div class="status-banner status-pending">
                        <i class="fas fa-clock" style="font-size:1.1rem"></i>
                        <div>Belum Check-in — Tunjukkan QR ini ke petugas</div>
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="ticket-footer">
                <span>🎫 QR E-Ticket System</span>
                <span>{{ now()->format('d M Y') }}</span>
            </div>
        </div>

        <button class="print-btn" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak / Simpan sebagai PDF
        </button>
    </div>

</body>

</html>
