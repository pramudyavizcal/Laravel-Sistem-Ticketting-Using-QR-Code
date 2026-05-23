@extends('layouts.admin')
@section('title', 'QR Scanner')
@section('page-title', 'QR Scanner')
@section('breadcrumb', 'Admin / Scanner Check-in')

@push('styles')
    <style>
        /* ─── SCANNER PAGE LAYOUT ──────────────────────────────────── */
        .scanner-page {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 1.25rem;
            align-items: start;
            height: calc(100vh - var(--header-height) - 3rem);
        }

        /* ─── LEFT: SCANNER MAIN ───────────────────────────────────── */
        .scanner-main {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            height: 100%;
        }

        /* Event selector bar */
        .event-bar {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: .875rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .05);
        }

        /* Camera wrapper */
        .camera-wrapper {
            flex: 1;
            background: #000;
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            min-height: 420px;
            border: 2px solid #e5e7f0;
        }

        .camera-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            color: rgba(0, 0, 0, .3);
        }

        .camera-placeholder .icon {
            font-size: 5rem;
        }

        .camera-placeholder p {
            font-size: .9rem;
        }

        /* QR reader override */
        #qr-reader {
            width: 100% !important;
            border: none !important;
            background: #000 !important;
        }

        #qr-reader video {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            border-radius: 0 !important;
        }

        #qr-reader img {
            display: none !important;
        }

        #qr-reader>div:last-child {
            display: none !important;
        }

        /* hide built-in UI */

        /* Scan frame overlay */
        .scan-frame-overlay {
            position: absolute;
            inset: 0;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .scan-frame {
            width: 240px;
            height: 240px;
            position: relative;
        }

        .scan-frame::before,
        .scan-frame::after {
            content: '';
            position: absolute;
            width: 40px;
            height: 40px;
            border-color: #6C63FF;
            border-style: solid;
        }

        .scan-frame::before {
            top: 0;
            left: 0;
            border-width: 3px 0 0 3px;
            border-radius: 4px 0 0 0;
        }

        .scan-frame::after {
            bottom: 0;
            right: 0;
            border-width: 0 3px 3px 0;
            border-radius: 0 0 4px 0;
        }

        .scan-frame .corner-tr,
        .scan-frame .corner-bl {
            position: absolute;
            width: 40px;
            height: 40px;
            border-color: #6C63FF;
            border-style: solid;
        }

        .scan-frame .corner-tr {
            top: 0;
            right: 0;
            border-width: 3px 3px 0 0;
            border-radius: 0 4px 0 0;
        }

        .scan-frame .corner-bl {
            bottom: 0;
            left: 0;
            border-width: 0 0 3px 3px;
            border-radius: 0 0 0 4px;
        }

        /* Scan laser line */
        .scan-laser {
            position: absolute;
            left: 8px;
            right: 8px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #6C63FF, #a78bfa, #6C63FF, transparent);
            border-radius: 2px;
            box-shadow: 0 0 8px #6C63FF;
            animation: laser 2.5s ease-in-out infinite;
            top: 10%;
        }

        @keyframes laser {
            0% {
                top: 10%;
                opacity: 1;
            }

            50% {
                top: 85%;
                opacity: 1;
            }

            100% {
                top: 10%;
                opacity: 1;
            }
        }

        /* Camera status bar */
        .camera-status {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: .75rem 1.25rem;
            background: linear-gradient(to top, rgba(0, 0, 0, .8), transparent);
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: .8rem;
            color: rgba(255, 255, 255, .7);
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            animation: pulse-dot 1.5s ease-in-out infinite;
        }

        .status-dot.inactive {
            background: #6b7280;
            animation: none;
        }

        @keyframes pulse-dot {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: .5;
                transform: scale(.75);
            }
        }

        /* Start button overlay */
        .start-overlay {
            position: absolute;
            inset: 0;
            background: rgba(15, 15, 30, .75);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            z-index: 5;
        }

        .btn-start-scan {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #6C63FF, #a78bfa);
            border: none;
            border-radius: 14px;
            color: #fff;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 8px 30px rgba(108, 99, 255, .5);
            transition: all .2s;
            font-family: 'Inter', sans-serif;
        }

        .btn-start-scan:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(108, 99, 255, .6);
        }

        /* Manual input */
        .manual-input-bar {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: .875rem 1.25rem;
            display: flex;
            align-items: center;
            gap: .75rem;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .05);
        }

        /* ─── RIGHT: STATS + LOG ───────────────────────────────────── */
        .scanner-side {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            height: 100%;
            overflow: hidden;
        }

        .stats-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .75rem;
        }

        .mini-stat {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: .875rem;
            text-align: center;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .05);
        }

        .mini-stat .val {
            font-size: 1.8rem;
            font-weight: 800;
            line-height: 1;
        }

        .mini-stat .lbl {
            font-size: .72rem;
            color: var(--text-muted);
            margin-top: .2rem;
        }

        /* Log panel */
        .log-panel {
            flex: 1;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .05);
        }

        .log-panel-header {
            padding: .875rem 1.25rem;
            border-bottom: 1px solid var(--border);
            font-weight: 700;
            color: var(--text);
            font-size: .875rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--surface-2);
        }

        .log-list {
            flex: 1;
            overflow-y: auto;
            max-height: 400px;
        }

        .log-item {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .75rem 1rem;
            border-bottom: 1px solid var(--border);
            animation: slideInLog .3s ease;
        }

        @keyframes slideInLog {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .log-item-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .log-item-icon.success {
            background: rgba(16, 185, 129, .15);
        }

        .log-item-icon.duplicate {
            background: rgba(245, 158, 11, .15);
        }

        .log-item-icon.invalid {
            background: rgba(239, 68, 68, .15);
        }

        .log-item-info {
            flex: 1;
            min-width: 0;
        }

        .log-item-name {
            font-weight: 600;
            color: var(--text);
            font-size: .83rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .log-item-meta {
            font-size: .72rem;
            color: var(--text-muted);
        }

        .log-item-time {
            font-size: .7rem;
            color: var(--text-muted);
            flex-shrink: 0;
        }

        /* ─── POPUP OVERLAY ────────────────────────────────────────── */
        .popup-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            opacity: 0;
            transition: opacity .25s ease;
        }

        .popup-overlay.show {
            pointer-events: auto;
            opacity: 1;
        }

        .popup-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            backdrop-filter: blur(4px);
        }

        .popup-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 400px;
            border-radius: 24px;
            padding: 2.5rem 2rem;
            text-align: center;
            box-shadow: 0 30px 80px rgba(0, 0, 0, .6);
            transform: scale(.85) translateY(20px);
            transition: transform .3s cubic-bezier(.34, 1.56, .64, 1);
        }

        .popup-overlay.show .popup-card {
            transform: scale(1) translateY(0);
        }

        /* Success */
        .popup-card.success {
            background: linear-gradient(145deg, #064e3b, #065f46);
            border: 1px solid rgba(16, 185, 129, .3);
        }

        /* Duplicate */
        .popup-card.duplicate {
            background: linear-gradient(145deg, #451a03, #78350f);
            border: 1px solid rgba(245, 158, 11, .3);
        }

        /* Invalid */
        .popup-card.invalid {
            background: linear-gradient(145deg, #450a0a, #7f1d1d);
            border: 1px solid rgba(239, 68, 68, .3);
        }

        /* Popup icon */
        .popup-icon-wrap {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            margin: 0 auto 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            animation: iconPop .4s cubic-bezier(.34, 1.56, .64, 1) .1s both;
        }

        @keyframes iconPop {
            from {
                transform: scale(0) rotate(-30deg);
                opacity: 0;
            }

            to {
                transform: scale(1) rotate(0);
                opacity: 1;
            }
        }

        .popup-card.success .popup-icon-wrap {
            background: rgba(16, 185, 129, .2);
        }

        .popup-card.duplicate .popup-icon-wrap {
            background: rgba(245, 158, 11, .2);
        }

        .popup-card.invalid .popup-icon-wrap {
            background: rgba(239, 68, 68, .2);
        }

        .popup-title {
            font-size: 1.4rem;
            font-weight: 900;
            color: #fff;
            margin-bottom: .5rem;
        }

        .popup-subtitle {
            font-size: .95rem;
            color: rgba(255, 255, 255, .7);
            margin-bottom: 1.25rem;
            line-height: 1.5;
        }

        .popup-info-box {
            background: rgba(0, 0, 0, .25);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.25rem;
            text-align: left;
        }

        .popup-info-row {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: .85rem;
            margin-bottom: .4rem;
            color: rgba(255, 255, 255, .85);
        }

        .popup-info-row:last-child {
            margin-bottom: 0;
        }

        .popup-info-row .lbl {
            color: rgba(255, 255, 255, .45);
            min-width: 70px;
            font-size: .78rem;
        }

        /* Progress bar auto-dismiss */
        .popup-progress {
            height: 4px;
            border-radius: 4px;
            background: rgba(255, 255, 255, .1);
            overflow: hidden;
            margin-top: .5rem;
        }

        .popup-progress-bar {
            height: 100%;
            border-radius: 4px;
            width: 100%;
            transition: width linear;
        }

        .popup-card.success .popup-progress-bar {
            background: #10b981;
        }

        .popup-card.duplicate .popup-progress-bar {
            background: #f59e0b;
        }

        .popup-card.invalid .popup-progress-bar {
            background: #ef4444;
        }

        /* ─── RESPONSIVE ───────────────────────────────────────────── */
        @media (max-width: 900px) {
            .scanner-page {
                grid-template-columns: 1fr;
                height: auto;
            }

            .camera-wrapper {
                min-height: 320px;
            }
        }
    </style>
@endpush

@section('content')

    @if(!$selectedEvent)
        {{-- ─── EVENT SELECTOR SCREEN ─────────────────────────────── --}}
        <div style="max-width:640px;margin:2rem auto;text-align:center">
            <div style="font-size:5rem;margin-bottom:1rem">📡</div>
            <h2 style="font-size:1.5rem;font-weight:800;color:var(--text);margin-bottom:.5rem">Pilih Event untuk Scan</h2>
            <p class="text-muted mb-3">Pilih event yang ingin dijalankan sesi check-in-nya</p>

            <div class="grid grid-2" style="text-align:left;gap:.75rem">
                @foreach($events as $event)
                    <a href="{{ route('admin.scanner') }}?event_id={{ $event->id }}" class="card"
                        style="text-decoration:none;padding:1.25rem;border-top:3px solid {{ $event->theme_color }};transition:transform .2s,box-shadow .2s"
                        onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform=''">
                        <div style="font-size:2rem;margin-bottom:.5rem">{{ $event->type_icon }}</div>
                        <div style="font-weight:700;color:var(--text);font-size:.9rem;margin-bottom:.25rem">
                            {{ Str::limit($event->name, 40) }}</div>
                        <div class="text-muted text-sm">📅 {{ $event->event_date->format('d M Y') }}</div>
                        <div class="text-muted text-sm">📍 {{ Str::limit($event->venue, 30) }}</div>
                        <div style="margin-top:.75rem;display:flex;align-items:center;gap:.5rem">
                            <span class="badge badge-info">{{ $event->attendees_count }} peserta</span>
                            <span class="badge badge-success">{{ $event->checked_in_count }} check-in</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

    @else
        {{-- ─── ACTIVE SCANNER SCREEN ─────────────────────────────── --}}
        <div class="scanner-page">

            {{-- LEFT: CAMERA + CONTROLS --}}
            <div class="scanner-main">

                {{-- Event bar --}}
                <div class="event-bar">
                    <div
                        style="width:44px;height:44px;border-radius:10px;background:{{ $selectedEvent->theme_color }}22;display:flex;align-items:center;justify-content:center;font-size:1.5rem;flex-shrink:0">
                        {{ $selectedEvent->type_icon }}
                    </div>
                    <div style="flex:1;min-width:0">
                        <div
                            style="font-weight:800;color:var(--text);font-size:.95rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                            {{ $selectedEvent->name }}
                        </div>
                        <div class="text-muted text-sm">📅 {{ $selectedEvent->event_date->format('d M Y') }} · 📍
                            {{ $selectedEvent->venue }}</div>
                    </div>
                    <a href="{{ route('admin.scanner') }}" class="btn btn-outline btn-sm" style="flex-shrink:0">
                        <i class="fas fa-exchange-alt"></i> Ganti
                    </a>
                </div>

                {{-- Camera --}}
                <div class="camera-wrapper" id="cameraWrapper">
                    {{-- QR Reader container --}}
                    <div id="qr-reader"></div>

                    {{-- Corner frame --}}
                    <div class="scan-frame-overlay" id="scanFrameOverlay" style="display:none">
                        <div class="scan-frame">
                            <div class="corner-tr"></div>
                            <div class="corner-bl"></div>
                            <div class="scan-laser"></div>
                        </div>
                    </div>

                    {{-- Start overlay --}}
                    <div class="start-overlay" id="startOverlay">
                        <div style="text-align:center;color:var(--border);margin-bottom:1rem">
                            <div style="font-size:3rem;margin-bottom:.5rem">📷</div>
                            <div style="font-size:.9rem">Kamera belum aktif</div>
                        </div>
                        <button class="btn-start-scan" onclick="startScanner()">
                            <i class="fas fa-play"></i> Mulai Scan
                        </button>
                    </div>

                    {{-- Status bar --}}
                    <div class="camera-status">
                        <div class="status-dot inactive" id="statusDot"></div>
                        <span id="statusText">Kamera belum aktif</span>
                        <span style="margin-left:auto;font-size:.75rem;color:var(--border)" id="totalScanned">
                            0 scan hari ini
                        </span>
                    </div>
                </div>

                {{-- Manual input --}}
                <div class="manual-input-bar">
                    <i class="fas fa-keyboard" style="color:var(--text-muted)"></i>
                    <input type="text" id="manualCode" class="form-control"
                        placeholder="Input manual: ketik/paste kode tiket lalu Enter..."
                        style="font-family:monospace;font-size:.85rem;border:none;background:transparent;flex:1;padding:0"
                        onkeydown="if(event.key==='Enter') processManual()">
                    <button onclick="processManual()" class="btn btn-primary btn-sm">
                        <i class="fas fa-search"></i> Cek
                    </button>
                </div>
            </div>

            {{-- RIGHT: STATS + LOG --}}
            <div class="scanner-side">

                {{-- Stats --}}
                <div class="stats-row">
                    <div class="mini-stat" style="border-top:3px solid #10b981">
                        <div class="val" id="statCheckedIn" style="color:#10b981">{{ $selectedEvent->checked_in_count }}</div>
                        <div class="lbl">✅ Check-in</div>
                    </div>
                    <div class="mini-stat" style="border-top:3px solid #f59e0b">
                        <div class="val" id="statPending" style="color:#f59e0b">
                            {{ $selectedEvent->attendees_count - $selectedEvent->checked_in_count }}
                        </div>
                        <div class="lbl">⏳ Belum</div>
                    </div>
                    <div class="mini-stat" style="border-top:3px solid #6C63FF">
                        <div class="val" id="statTotal" style="color:#a78bfa">{{ $selectedEvent->attendees_count }}</div>
                        <div class="lbl">👥 Total</div>
                    </div>
                    <div class="mini-stat" style="border-top:3px solid #3b82f6">
                        @php $pct = $selectedEvent->attendees_count > 0 ? round($selectedEvent->checked_in_count / $selectedEvent->attendees_count * 100) : 0 @endphp
                        <div class="val" id="statPct" style="color:#60a5fa">{{ $pct }}%</div>
                        <div class="lbl">📊 Progress</div>
                    </div>
                </div>

                {{-- Progress bar --}}
                <div
                    style="background:var(--bg-2);border:1px solid var(--border);border-radius:10px;padding:.875rem 1.25rem">
                    <div style="display:flex;justify-content:space-between;font-size:.78rem;margin-bottom:.5rem">
                        <span style="color:var(--text-muted)">Progress Check-in</span>
                        <span style="color:var(--text);font-weight:700"
                            id="progressLabel">{{ $selectedEvent->checked_in_count }}/{{ $selectedEvent->attendees_count }}</span>
                    </div>
                    <div style="background:var(--border);border-radius:6px;height:10px;overflow:hidden">
                        <div id="progressBar"
                            style="height:100%;width:{{ $pct }}%;background:linear-gradient(90deg,{{ $selectedEvent->theme_color }},#a78bfa);border-radius:6px;transition:width .6s ease">
                        </div>
                    </div>
                </div>

                {{-- Scan Log --}}
                <div class="log-panel">
                    <div class="log-panel-header">
                        <span>📋 Scan Terbaru</span>
                        <span id="logBadge" class="badge badge-info">{{ $recentLogs->count() }}</span>
                    </div>
                    <div class="log-list" id="logList">
                        @forelse($recentLogs as $log)
                            <div class="log-item">
                                <div class="log-item-icon {{ $log->result }}">
                                    {{ $log->result === 'success' ? '✅' : ($log->result === 'duplicate' ? '⚠️' : '❌') }}
                                </div>
                                <div class="log-item-info">
                                    <div class="log-item-name">{{ $log->attendee?->name ?? 'Unknown' }}</div>
                                    <div class="log-item-meta">
                                        {{ $log->attendee?->ticket_type ?? '—' }}
                                        @if($log->attendee?->seat_number) · Kursi {{ $log->attendee->seat_number }} @endif
                                    </div>
                                </div>
                                <div class="log-item-time">{{ $log->created_at->format('H:i') }}</div>
                            </div>
                        @empty
                            <div id="emptyLogMsg" style="padding:2.5rem;text-align:center;color:var(--text-muted)">
                                <div style="font-size:2.5rem;margin-bottom:.5rem">📭</div>
                                <div>Belum ada scan</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ─── POPUP OVERLAY ──────────────────────────────────────── --}}
    <div class="popup-overlay" id="popupOverlay">
        <div class="popup-backdrop" onclick="closePopup()"></div>
        <div class="popup-card" id="popupCard">
            <div class="popup-icon-wrap" id="popupIcon">✅</div>
            <div class="popup-title" id="popupTitle">Check-in Berhasil!</div>
            <div class="popup-subtitle" id="popupSubtitle"></div>

            <div class="popup-info-box" id="popupInfoBox">
                <div class="popup-info-row">
                    <span class="lbl">Nama</span>
                    <span id="piName">—</span>
                </div>
                <div class="popup-info-row">
                    <span class="lbl">Tiket</span>
                    <span id="piTicket">—</span>
                </div>
                <div class="popup-info-row" id="piSeatRow">
                    <span class="lbl">Kursi</span>
                    <span id="piSeat">—</span>
                </div>
                <div class="popup-info-row" id="piTimeRow" style="display:none">
                    <span class="lbl">Scan pertama</span>
                    <span id="piTime" style="color:#f59e0b">—</span>
                </div>
            </div>

            <div class="popup-progress">
                <div class="popup-progress-bar" id="popupProgressBar"></div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        // ─── CONFIG ──────────────────────────────────────────────
        const EVENT_ID = {{ $selectedEvent?->id ?? 'null' }};
        const VERIFY_URL = "{{ route('admin.scanner.verify') }}";
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;

        // State
        let html5QrCode = null;
        let isScanning = false;
        let isProcessing = false; // prevent double scan
        let popupTimer = null;
        let sessionScans = 0;
        let checkedInCount = {{ $selectedEvent?->checked_in_count ?? 0 }};
        let totalCount = {{ $selectedEvent?->attendees_count ?? 0 }};
        let totalQuota = {{ $selectedEvent?->quota ?? 0 }};

        // Auto-start if event selected
        @if($selectedEvent)
            document.addEventListener('DOMContentLoaded', () => {
                // Auto-start scanner after 500ms
                setTimeout(startScanner, 500);
            });
        @endif

            // ─── SCANNER CONTROLS ────────────────────────────────────
            function startScanner() {
                if (!EVENT_ID) return;

                const startOverlay = document.getElementById('startOverlay');

                html5QrCode = new Html5Qrcode("qr-reader");

                Html5Qrcode.getCameras().then(cameras => {
                    if (!cameras || cameras.length === 0) {
                        showCameraError('Tidak ada kamera ditemukan');
                        return;
                    }

                    // Prefer back camera
                    const cam = cameras.find(c => /back|rear|environment/i.test(c.label)) || cameras[cameras.length - 1];

                    html5QrCode.start(
                        cam.id,
                        {
                            fps: 15,
                            qrbox: { width: 230, height: 230 },
                            aspectRatio: 1.0,
                            disableFlip: false,
                        },
                        onQrDetected,
                        () => { } // suppress scan errors
                    ).then(() => {
                        isScanning = true;
                        startOverlay.style.display = 'none';
                        document.getElementById('scanFrameOverlay').style.display = 'flex';
                        document.getElementById('statusDot').classList.remove('inactive');
                        document.getElementById('statusText').textContent = 'Kamera aktif — Arahkan ke QR Code tiket';
                    }).catch(err => {
                        showCameraError('Gagal mengakses kamera: ' + err);
                    });
                }).catch(err => {
                    showCameraError('Izin kamera ditolak atau tidak tersedia');
                });
            }

        function showCameraError(msg) {
            document.getElementById('statusText').textContent = msg;
            document.getElementById('startOverlay').innerHTML = `
            <div style="text-align:center;color:var(--border)">
                <div style="font-size:3rem;margin-bottom:.75rem">🚫</div>
                <div style="font-size:.9rem">${msg}</div>
                <div style="font-size:.8rem;margin-top:.5rem;color:var(--border)">Gunakan input manual di bawah</div>
            </div>`;
        }

        // ─── QR DETECTED ─────────────────────────────────────────
        function onQrDetected(decodedText) {
            if (isProcessing) return;
            isProcessing = true;

            // Visual feedback: flash border
            const wrapper = document.getElementById('cameraWrapper');
            wrapper.style.borderColor = '#6C63FF';
            wrapper.style.boxShadow = '0 0 30px rgba(108,99,255,.5)';

            verifyTicket(decodedText.trim().toUpperCase());
        }

        function processManual() {
            const code = document.getElementById('manualCode').value.trim().toUpperCase();
            if (!code) return;
            if (!EVENT_ID) {
                alert('Pilih event terlebih dahulu!');
                return;
            }
            document.getElementById('manualCode').value = '';
            verifyTicket(code);
        }

        // ─── API VERIFY ───────────────────────────────────────────
        function verifyTicket(code) {
            fetch(VERIFY_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ ticket_code: code, event_id: EVENT_ID }),
            })
                .then(r => r.json())
                .then(data => {
                    handleScanResult(data);
                })
                .catch(() => {
                    showPopup('invalid', { message: 'Koneksi gagal, coba lagi.' });
                });
        }

        // ─── HANDLE RESULT & SHOW POPUP ──────────────────────────
        function handleScanResult(data) {
            // Reset camera border
            const wrapper = document.getElementById('cameraWrapper');
            wrapper.style.borderColor = '';
            wrapper.style.boxShadow = '';

            if (data.result === 'success') {
                // Update counters
                checkedInCount++;
                updateStats();
                addLogEntry(data.attendee?.name ?? '—', data.attendee?.ticket_type ?? '—',
                    data.attendee?.seat_number ?? '', 'success');
                playBeep('success');
                showPopup('success', data);

            } else if (data.result === 'duplicate') {
                addLogEntry(data.attendee?.name ?? '—', data.attendee?.ticket_type ?? '—',
                    data.attendee?.seat_number ?? '', 'duplicate');
                playBeep('duplicate');
                showPopup('duplicate', data);

            } else {
                playBeep('invalid');
                showPopup('invalid', data);
            }
        }

        // ─── POPUP ────────────────────────────────────────────────
        function showPopup(type, data) {
            const overlay = document.getElementById('popupOverlay');
            const card = document.getElementById('popupCard');
            const icon = document.getElementById('popupIcon');
            const title = document.getElementById('popupTitle');
            const subtitle = document.getElementById('popupSubtitle');
            const piName = document.getElementById('piName');
            const piTicket = document.getElementById('piTicket');
            const piSeat = document.getElementById('piSeat');
            const piSeatRow = document.getElementById('piSeatRow');
            const piTimeRow = document.getElementById('piTimeRow');
            const piTime = document.getElementById('piTime');
            const progressBar = document.getElementById('popupProgressBar');

            // Reset classes
            card.className = 'popup-card ' + type;

            if (type === 'success') {
                icon.textContent = '✅';
                title.textContent = 'Check-in Berhasil!';
                subtitle.textContent = `Selamat datang, ${data.attendee?.name ?? ''}!`;
                piName.textContent = data.attendee?.name ?? '—';
                piTicket.textContent = data.attendee?.ticket_type ?? '—';
                piSeat.textContent = data.attendee?.seat_number || 'Tidak ada';
                piSeatRow.style.display = 'flex';
                piTimeRow.style.display = 'none';

            } else if (type === 'duplicate') {
                icon.textContent = '⚠️';
                title.textContent = 'Tiket Sudah Digunakan!';
                subtitle.textContent = 'Peserta ini sudah melakukan check-in sebelumnya.';
                piName.textContent = data.attendee?.name ?? '—';
                piTicket.textContent = data.attendee?.ticket_type ?? '—';
                piSeat.textContent = data.attendee?.seat_number || 'Tidak ada';
                piSeatRow.style.display = 'flex';
                piTime.textContent = data.attendee?.checked_in_at ?? '—';
                piTimeRow.style.display = 'flex';

            } else {
                icon.textContent = '❌';
                title.textContent = 'QR Tidak Valid!';
                subtitle.textContent = 'Kode QR tidak terdaftar untuk event ini.';
                document.getElementById('popupInfoBox').style.display = 'none';
            }

            // Reset info box display
            if (type !== 'invalid') {
                document.getElementById('popupInfoBox').style.display = 'block';
            }

            // Show overlay
            overlay.classList.add('show');

            // Auto-dismiss countdown
            clearTimeout(popupTimer);
            const DISMISS_MS = type === 'success' ? 2800 : type === 'duplicate' ? 3500 : 2500;

            // Animate progress bar
            progressBar.style.transition = 'none';
            progressBar.style.width = '100%';
            setTimeout(() => {
                progressBar.style.transition = `width ${DISMISS_MS}ms linear`;
                progressBar.style.width = '0%';
            }, 50);

            popupTimer = setTimeout(() => {
                closePopup();
            }, DISMISS_MS);
        }

        function closePopup() {
            clearTimeout(popupTimer);
            const overlay = document.getElementById('popupOverlay');
            overlay.classList.remove('show');

            // Resume scanning after popup closes
            setTimeout(() => {
                isProcessing = false;
                sessionScans++;
                document.getElementById('totalScanned').textContent = sessionScans + ' scan sesi ini';
            }, 300);
        }

        // ─── STATS UPDATE ─────────────────────────────────────────
        function updateStats() {
            const pending = totalCount - checkedInCount;
            const pct = totalCount > 0 ? Math.round(checkedInCount / totalCount * 100) : 0;

            document.getElementById('statCheckedIn').textContent = checkedInCount;
            document.getElementById('statPending').textContent = pending;
            document.getElementById('statPct').textContent = pct + '%';
            document.getElementById('progressBar').style.width = pct + '%';
            document.getElementById('progressLabel').textContent = checkedInCount + '/' + totalCount;
        }

        // ─── LOG ENTRY ────────────────────────────────────────────
        function addLogEntry(name, ticketType, seat, result) {
            const emptyMsg = document.getElementById('emptyLogMsg');
            if (emptyMsg) emptyMsg.remove();

            const icons = { success: '✅', duplicate: '⚠️', invalid: '❌' };
            const now = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

            const item = document.createElement('div');
            item.className = 'log-item';
            item.innerHTML = `
            <div class="log-item-icon ${result}">${icons[result]}</div>
            <div class="log-item-info">
                <div class="log-item-name">${name}</div>
                <div class="log-item-meta">${ticketType}${seat ? ' · Kursi ' + seat : ''}</div>
            </div>
            <div class="log-item-time">${now}</div>
        `;

            const list = document.getElementById('logList');
            list.insertBefore(item, list.firstChild);

            // Update badge
            const badge = document.getElementById('logBadge');
            badge.textContent = parseInt(badge.textContent || 0) + 1;
        }

        // ─── SOUND FEEDBACK ───────────────────────────────────────
        function playBeep(type) {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain);
                gain.connect(ctx.destination);

                if (type === 'success') {
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(523, ctx.currentTime);       // C5
                    osc.frequency.setValueAtTime(659, ctx.currentTime + .12); // E5
                    osc.frequency.setValueAtTime(784, ctx.currentTime + .24); // G5
                    gain.gain.setValueAtTime(.4, ctx.currentTime);
                    gain.gain.exponentialRampToValueAtTime(.01, ctx.currentTime + .5);
                    osc.start(ctx.currentTime);
                    osc.stop(ctx.currentTime + .5);
                } else if (type === 'duplicate') {
                    osc.type = 'square';
                    osc.frequency.setValueAtTime(330, ctx.currentTime);
                    osc.frequency.setValueAtTime(220, ctx.currentTime + .15);
                    gain.gain.setValueAtTime(.25, ctx.currentTime);
                    gain.gain.exponentialRampToValueAtTime(.01, ctx.currentTime + .4);
                    osc.start(ctx.currentTime);
                    osc.stop(ctx.currentTime + .4);
                } else {
                    osc.type = 'sawtooth';
                    osc.frequency.setValueAtTime(200, ctx.currentTime);
                    osc.frequency.setValueAtTime(150, ctx.currentTime + .1);
                    gain.gain.setValueAtTime(.25, ctx.currentTime);
                    gain.gain.exponentialRampToValueAtTime(.01, ctx.currentTime + .3);
                    osc.start(ctx.currentTime);
                    osc.stop(ctx.currentTime + .3);
                }
            } catch (e) { }
        }

        // ─── KEYBOARD SHORTCUT: ESC to close popup ────────────────
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closePopup();
        });
    </script>
@endpush