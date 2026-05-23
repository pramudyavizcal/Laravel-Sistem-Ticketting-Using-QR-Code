<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $siteName }} - Event & Atraksi</title>
    <link rel="icon" href="{{ $siteFaviconUrl }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --ink: #1d2340;
            --muted: #707a97;
            --line: #e5e8f2;
            --bg: #f5f7fb;
            --navy: #1c1f4a;
            --navy-2: #25295f;
            --accent: #ffb02e;
            --primary: #6b5cff;
            --teal: #21b6a8;
            --card: #ffffff;
            --shadow: 0 18px 44px rgba(25, 28, 61, 0.09);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            font-family: 'Inter', system-ui, sans-serif;
            color: var(--ink);
            background:
                linear-gradient(180deg, #ffffff 0%, #f6f8fd 100%);
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            background:
                linear-gradient(115deg, rgba(107, 92, 255, 0.04), transparent 34%),
                linear-gradient(295deg, rgba(33, 182, 168, 0.05), transparent 30%),
                repeating-linear-gradient(90deg, rgba(29, 35, 64, 0.025) 0 1px, transparent 1px 110px);
            opacity: 0.8;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .shell {
            width: min(1530px, calc(100% - 32px));
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .topbar {
            margin-top: 14px;
            padding: 18px 22px;
            min-height: 110px;
            border-radius: 26px;
            background: linear-gradient(180deg, var(--navy) 0%, #181a3e 100%);
            box-shadow: 0 20px 40px rgba(25, 28, 61, 0.18);
            display: grid;
            grid-template-columns: auto auto 1fr auto;
            gap: 18px;
            align-items: center;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: #fff;
            font-size: 1.05rem;
            font-weight: 900;
            white-space: nowrap;
        }

        .brand-mark {
            width: 86px;
            height: 44px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            color: #fff;
            font-weight: 900;
            letter-spacing: -0.02em;
            background: linear-gradient(90deg, #2d3380 0 50%, var(--accent) 50% 100%);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.08);
        }

        .brand-mark span {
            display: inline-flex;
            align-items: center;
            gap: 2px;
            font-size: 0.88rem;
        }

        .brand-mark img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 6px;
        }

        .top-links {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-left: 8px;
        }

        .top-link {
            color: rgba(255, 255, 255, 0.92);
            font-size: 0.95rem;
            font-weight: 700;
        }

        .searchbar {
            display: flex;
            align-items: center;
            gap: 12px;
            height: 60px;
            padding: 0 16px 0 18px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.98);
            box-shadow: inset 0 0 0 1px rgba(18, 21, 45, 0.08);
            width: 100%;
        }

        .searchbar i,
        .search-submit {
            color: #8a90a8;
            font-size: 1.05rem;
        }

        .searchbar input {
            width: 100%;
            border: 0;
            outline: 0;
            background: transparent;
            color: var(--ink);
            font: inherit;
            font-size: 1rem;
        }

        .search-submit,
        .search-clear {
            border: 0;
            background: transparent;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .search-clear {
            width: 30px;
            height: 30px;
            border-radius: 999px;
            color: #8a90a8;
            background: rgba(138, 144, 168, 0.12);
            flex: 0 0 auto;
        }

        .searchbar input::placeholder {
            color: #6f7692;
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .icon-btn {
            width: 44px;
            height: 44px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            display: grid;
            place-items: center;
            color: #fff;
            background: rgba(255, 255, 255, 0.06);
        }

        .login-btn {
            min-width: 176px;
            height: 48px;
            padding: 0 18px;
            border: 0;
            border-radius: 8px;
            background: var(--accent);
            color: #1b2450;
            font: inherit;
            font-size: 0.98rem;
            font-weight: 900;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 10px 20px rgba(255, 176, 46, 0.22);
        }

        .hero {
            margin-top: 16px;
        }

        .hero-rail {
            position: relative;
            min-height: 520px;
        }

        .hero-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 48px;
            height: 48px;
            border: 1px solid #d8ddeb;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.96);
            display: grid;
            place-items: center;
            box-shadow: var(--shadow);
            z-index: 3;
            color: var(--ink);
        }

        .hero-nav.prev {
            left: 16px;
        }

        .hero-nav.next {
            right: 16px;
        }

        .hero-card {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            background: #fff;
            box-shadow: var(--shadow);
            min-height: 520px;
        }

        .hero-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            inset: 0;
        }

        .hero-card::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(20, 22, 50, 0.06)),
                linear-gradient(120deg, rgba(255, 255, 255, 0.08), transparent 40%, transparent 75%, rgba(255, 255, 255, 0.08));
        }

        .hero-copy {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
            padding: 28px;
            color: #fff;
            background: linear-gradient(180deg, rgba(12, 14, 32, 0) 0%, rgba(12, 14, 32, 0.8) 78%);
        }

        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            font-size: 0.75rem;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .hero-title {
            font-size: clamp(1.6rem, 2vw, 2.25rem);
            line-height: 1.03;
            font-weight: 900;
            letter-spacing: -0.04em;
        }

        .hero-meta {
            margin-top: 8px;
            color: rgba(255, 255, 255, 0.82);
            font-size: 0.95rem;
            font-weight: 600;
        }

        .hero-description {
            margin-top: 8px;
            color: rgba(255, 255, 255, 0.74);
            font-size: 0.85rem;
            line-height: 1.45;
        }

        .hero-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 18px;
        }

        .hero-footer-stack {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 16px;
        }

        .hero-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            color: #fff;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .hero-price {
            font-size: 0.98rem;
            font-weight: 800;
        }

        .hero-cta {
            height: 42px;
            padding: 0 14px;
            border-radius: 999px;
            background: #fff;
            color: #13173a;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            font-weight: 800;
        }

        .hero-mini {
            position: absolute;
            top: 16px;
            left: 16px;
            z-index: 1;
            padding: 8px 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.92);
            color: var(--ink);
            font-size: 0.72rem;
            font-weight: 800;
        }

        .hero-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 12px;
        }

        .hero-dot {
            width: 24px;
            height: 4px;
            border: 0;
            border-radius: 999px;
            background: #d8ddeb;
        }

        .hero-dot.active {
            background: var(--accent);
        }

        .section {
            margin-top: 34px;
            padding-bottom: 36px;
        }

        .section-head {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
        }

        .section-title {
            font-size: clamp(1.8rem, 3vw, 2.55rem);
            line-height: 1.08;
            font-weight: 900;
            letter-spacing: -0.05em;
        }

        .section-link {
            color: #2f69ff;
            font-size: 1rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .section-subtitle {
            margin-top: 8px;
            color: var(--muted);
            font-size: 0.95rem;
            font-weight: 600;
        }

        .section-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .grid-nav {
            width: 44px;
            height: 44px;
            border: 1px solid #d8ddeb;
            border-radius: 14px;
            background: #fff;
            box-shadow: var(--shadow);
            display: grid;
            place-items: center;
            color: var(--ink);
        }

        .grid-nav.is-disabled {
            opacity: 0.45;
            pointer-events: none;
        }

        .event-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .event-card {
            overflow: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100%;
            border-radius: 18px;
            background: linear-gradient(180deg, color-mix(in srgb, var(--event-color) 9%, #ffffff) 0%, #ffffff 56%);
            box-shadow: var(--shadow);
            border: 1px solid rgba(229, 232, 242, 0.9);
        }

        .event-poster {
            position: relative;
            width: 100%;
            aspect-ratio: 16 / 10;
            overflow: hidden;
            background: #dde1ec;
        }

        .event-poster img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .event-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(12, 15, 35, 0.02) 0%, rgba(12, 15, 35, 0.22) 100%);
        }

        .event-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            z-index: 1;
            padding: 6px 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.92);
            color: var(--ink);
            font-size: 0.72rem;
            font-weight: 800;
        }

        .event-caption {
            position: absolute;
            left: 12px;
            right: 12px;
            bottom: 12px;
            z-index: 1;
            padding: 8px 10px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            color: var(--ink);
        }

        .event-caption-title {
            font-size: 0.76rem;
            font-weight: 900;
            line-height: 1.2;
        }

        .event-caption-meta {
            margin-top: 4px;
            color: var(--muted);
            font-size: 0.7rem;
            font-weight: 700;
            line-height: 1.35;
        }

        .event-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 14px 14px 16px;
            min-width: 0;
            background:
                radial-gradient(circle at top right, color-mix(in srgb, var(--teal) 12%, transparent)),
                linear-gradient(180deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0));
        }

        .event-name {
            font-size: 1.02rem;
            line-height: 1.25;
            font-weight: 800;
        }

        .event-info {
            margin-top: 6px;
            color: var(--muted);
            font-size: 0.82rem;
            font-weight: 600;
        }

        .event-meta {
            display: grid;
            gap: 8px;
            margin-top: 14px;
            padding-top: 12px;
            border-top: 1px solid rgba(229, 232, 242, 0.9);
        }

        .event-card:hover .event-body {
            background:
                radial-gradient(circle at top right, color-mix(in srgb, var(--event-color) 16%, transparent), transparent 52%),
                linear-gradient(180deg, rgba(255, 255, 255, 0.28), rgba(255, 255, 255, 0));
        }

        .event-price {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            width: fit-content;
            min-height: 34px;
            padding: 0.42rem 0.72rem 0.42rem 0.48rem;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.72);
            color: var(--ink);
            font-size: 0.84rem;
            font-weight: 900;
            box-shadow: inset 0 0 0 1px color-mix(in srgb, var(--event-color) 18%, #e5e8f2);
        }

        .event-price i {
            width: 22px;
            height: 22px;
            display: grid;
            place-items: center;
            border-radius: 8px;
            background: color-mix(in srgb, var(--event-color) 16%, #ffffff);
            color: color-mix(in srgb, var(--event-color) 82%, #151936);
            font-size: 0.72rem;
        }

        .event-spot {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            width: fit-content;
            padding: 0.38rem 0.65rem;
            border-radius: 999px;
            background: rgba(110, 118, 150, 0.08);
            color: var(--ink);
            font-size: 0.75rem;
            font-weight: 800;
        }

        .empty-state {
            padding: 40px 24px;
            border: 1px dashed #d5d9e7;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.72);
            text-align: center;
            color: var(--muted);
            font-weight: 700;
        }

        .pagination {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 18px;
        }

        .pagination a,
        .pagination span {
            min-width: 42px;
            height: 42px;
            padding: 0 14px;
            border-radius: 12px;
            border: 1px solid #d8ddeb;
            background: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--ink);
            font-size: 0.95rem;
            font-weight: 700;
            box-shadow: var(--shadow);
        }

        .pagination .active span {
            background: var(--navy);
            color: #fff;
            border-color: var(--navy);
        }

        .footer {
            padding: 28px 0 34px;
            color: var(--muted);
            font-size: 0.9rem;
            font-weight: 600;
            text-align: center;
        }

        @media (max-width: 1200px) {
            .topbar {
                grid-template-columns: auto 1fr auto;
            }

            .top-links {
                display: none;
            }
        }

        @media (max-width: 1080px) {
            .event-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 780px) {
            .shell {
                width: min(100% - 20px, 1530px);
            }

            .topbar {
                padding: 14px;
                grid-template-columns: 1fr auto;
                gap: 12px;
                min-height: auto;
            }

            .searchbar {
                grid-column: 1 / -1;
                order: 3;
            }

            .login-btn {
                min-width: 0;
                padding: 0 14px;
            }

            .hero-rail {
                min-height: auto;
            }

            .hero-nav {
                width: 42px;
                height: 42px;
            }

            .hero-card {
                min-height: 400px;
            }

            .event-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    @php
        $posterFallbacks = [
            'wisuda' => asset('assets/poster-wisuda.png'),
            'seminar' => asset('assets/poster-seminar.png'),
            'konser' => asset('assets/poster-konser.png'),
            'workshop' => asset('assets/poster-workshop.png'),
        ];

        $mapEvent = function ($event) use ($posterFallbacks) {
            $poster = $event->banner_path ? asset('storage/' . $event->banner_path) : ($posterFallbacks[$event->type] ?? asset('assets/poster-konser.png'));

            return [
                'id' => $event->id,
                'name' => $event->name,
                'description' => $event->description,
                'type' => $event->type_label,
                'icon' => $event->type_icon,
                'date' => $event->formatted_date,
                'time' => substr($event->event_time, 0, 5) . ' WIB',
                'venue' => $event->venue,
                'poster' => $poster,
                'price' => $event->is_paid ? 'Rp ' . number_format($event->price, 0, ',', '.') : 'Gratis',
                'link' => route('event.public_show', $event->id),
                'theme' => $event->theme_color,
                'remaining' => max(0, (int) $event->quota - (int) $event->attendees_count),
                'searched' => strtolower($event->name . ' ' . $event->type_label . ' ' . $event->organizer . ' ' . $event->venue),
            ];
        };

        $eventsForUi = $events->getCollection()->values()->map($mapEvent)->values();
        $sliderEventsForUi = collect($sliderEvents ?? $events->getCollection())->values()->map($mapEvent)->values();

        if ($sliderEventsForUi->isEmpty()) {
            $sliderEventsForUi = $eventsForUi;
        }
    @endphp

    <header class="shell">
        <nav class="topbar" aria-label="Navigasi utama">
            <a href="{{ route('home') }}" class="brand">
                <span class="brand-mark">
                    @if($siteLogoUrl)
                        <img src="{{ $siteLogoUrl }}" alt="{{ $siteName }}">
                    @else
                        <span>{{ $siteName }}</span>
                    @endif
                </span>
            </a>

            <div class="top-links">
                <a href="#events" class="top-link">Event</a>
            </div>

            <form class="searchbar" role="search" action="{{ route('home') }}" method="GET">
                <button class="search-submit" type="submit" aria-label="Cari event">
                    <i class="fas fa-magnifying-glass"></i>
                </button>
                <input id="eventSearch" name="q" type="search" value="{{ $search ?? request('q') }}" placeholder="Cari event dan atraksi di sini ...">
                @if(!empty($search))
                    <a class="search-clear" href="{{ route('home') }}" aria-label="Hapus pencarian">
                        <i class="fas fa-xmark"></i>
                    </a>
                @endif
            </form>

            <div class="top-actions">
                <div class="icon-btn" aria-hidden="true"><i class="fas fa-ticket"></i></div>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="login-btn"><i class="fas fa-lock"></i> Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="login-btn"><i class="fas fa-lock"></i> Masuk</a>
                @endauth
            </div>
        </nav>
    </header>

    <main class="shell">
        <section class="hero" aria-label="Sorotan event">
            <div class="hero-rail">
                <button class="hero-nav prev" type="button" aria-label="Sebelumnya">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <button class="hero-nav next" type="button" aria-label="Berikutnya">
                    <i class="fas fa-arrow-right"></i>
                </button>

                <article class="hero-card main" data-slot="main"></article>
            </div>
            <div class="hero-dots" id="heroDots" aria-label="Navigasi slide"></div>
        </section>

        <section id="events" class="section">
            <div class="section-head">
                <div>
                    <h2 class="section-title">{{ !empty($search) ? 'Hasil Pencarian' : 'Event Terbaru' }}</h2>
                    @if(!empty($search))
                        <p class="section-subtitle">Menampilkan hasil untuk "{{ $search }}"</p>
                    @endif
                </div>
                <div class="section-actions">
                    <a href="{{ route('home') }}#events" class="section-link">Lihat semua</a>
                    @if($events->previousPageUrl())
                        <a href="{{ $events->previousPageUrl() }}" class="grid-nav" aria-label="Halaman sebelumnya"><i class="fas fa-arrow-left"></i></a>
                    @else
                        <span class="grid-nav is-disabled" aria-hidden="true"><i class="fas fa-arrow-left"></i></span>
                    @endif
                    @if($events->nextPageUrl())
                        <a href="{{ $events->nextPageUrl() }}" class="grid-nav" aria-label="Halaman berikutnya"><i class="fas fa-arrow-right"></i></a>
                    @else
                        <span class="grid-nav is-disabled" aria-hidden="true"><i class="fas fa-arrow-right"></i></span>
                    @endif
                </div>
            </div>

            <div class="event-grid" id="eventGrid">
                @forelse($eventsForUi as $event)
                    <article class="event-card" data-search="{{ $event['searched'] }}">
                        <a href="{{ $event['link'] }}" class="event-poster" style="--event-color: {{ $event['theme'] }};">
                            <img src="{{ $event['poster'] }}" alt="{{ $event['name'] }}">
                            <span class="event-overlay"></span>
                            <span class="event-badge">{{ $event['icon'] }} {{ $event['type'] }}</span>
                            <div class="event-caption">
                                <div class="event-caption-title">{{ $event['date'] }}</div>
                                <div class="event-caption-meta">{{ \Illuminate\Support\Str::limit($event['venue'], 42) }}</div>
                            </div>
                        </a>
                        <div class="event-body">
                            <div class="event-name">{{ $event['name'] }}</div>
                            <div class="event-info">{{ $event['date'] }} &middot; {{ \Illuminate\Support\Str::limit($event['venue'], 34) }}</div>
                            <div class="event-meta">
                                <span class="event-price">
                                    <i class="fas {{ $event['price'] === 'Gratis' ? 'fa-ticket' : 'fa-tag' }}"></i>
                                    {{ $event['price'] }}
                                </span>
                                <span class="event-spot"><i class="fas fa-chair"></i> Tersedia {{ $event['remaining'] }} kursi</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="empty-state">Belum ada event yang tersedia saat ini.</div>
                @endforelse
            </div>

            @if($events->hasPages())
                <div class="pagination">
                    @if($events->onFirstPage())
                        <span aria-hidden="true">&laquo;</span>
                    @else
                        <a href="{{ $events->previousPageUrl() }}" rel="prev">&laquo;</a>
                    @endif

                    @foreach($events->getUrlRange(1, $events->lastPage()) as $page => $url)
                        @if($page == $events->currentPage())
                            <span class="active"><span>{{ $page }}</span></span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($events->hasMorePages())
                        <a href="{{ $events->nextPageUrl() }}" rel="next">&raquo;</a>
                    @else
                        <span aria-hidden="true">&raquo;</span>
                    @endif
                </div>
            @endif
        </section>

        <footer class="footer">
            &copy; {{ date('Y') }} {{ $siteName }} System
        </footer>
    </main>

    <script>
        const slides = @json($sliderEventsForUi);
        const slots = {
            main: document.querySelector('[data-slot="main"]'),
        };
        const dotsWrap = document.getElementById('heroDots');
        const prevBtn = document.querySelector('.hero-nav.prev');
        const nextBtn = document.querySelector('.hero-nav.next');
        const total = slides.length || 1;
        let activeIndex = slides.length > 2 ? 2 : 0;

        function renderSlide(event) {
            if (!event) return '';
            const escapeHtml = (value) => String(value)
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');

            const name = escapeHtml(event.name);
            const venue = escapeHtml(event.venue);
            const date = escapeHtml(event.date);
            const time = escapeHtml(event.time);
            const type = escapeHtml(event.type);
            const icon = escapeHtml(event.icon);
            const price = escapeHtml(event.price);
            const link = escapeHtml(event.link);
            const description = escapeHtml(event.description || 'Buka detail event untuk melihat informasi dan daftar tiket.');

            return `
                <img src="${event.poster}" alt="${name}">
                <span class="hero-mini">${icon} ${type}</span>
                <div class="hero-copy">
                    <div class="hero-kicker"><i class="fas fa-location-dot"></i> ${venue}</div>
                    <div class="hero-title">${name}</div>
                    <div class="hero-meta">${date} &middot; ${time}</div>
                    <div class="hero-description">${description}</div>
                    <div class="hero-footer-stack">
                        <span class="hero-chip"><i class="fas fa-calendar-days"></i>${date}</span>
                        <span class="hero-chip"><i class="fas fa-clock"></i>${time}</span>
                        <span class="hero-chip"><i class="fas fa-ticket"></i>${price}</span>
                    </div>
                    <div class="hero-footer">
                        <span class="hero-price">${price}</span>
                        <a class="hero-cta" href="${link}">Lihat event <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            `;
        }

        function renderDots() {
            dotsWrap.innerHTML = slides.map((_, index) => `
                <button class="hero-dot ${index === activeIndex ? 'active' : ''}" type="button" data-dot="${index}" aria-label="Slide ${index + 1}"></button>
            `).join('');
            dotsWrap.querySelectorAll('.hero-dot').forEach(dot => {
                dot.addEventListener('click', () => {
                    activeIndex = Number(dot.dataset.dot);
                    renderHero();
                });
            });
        }

        function renderHero() {
            if (!slides.length) return;
            const main = slides[activeIndex];
            slots.main.innerHTML = renderSlide(main, 'main');
            prevBtn.style.display = total > 1 ? '' : 'none';
            nextBtn.style.display = total > 1 ? '' : 'none';
            renderDots();
        }

        function moveHero(direction) {
            activeIndex = (activeIndex + direction + total) % total;
            renderHero();
        }

        if (slides.length) {
            renderHero();
            if (slides.length > 1) {
                prevBtn.addEventListener('click', () => moveHero(-1));
                nextBtn.addEventListener('click', () => moveHero(1));
                setInterval(() => moveHero(1), 6500);
            }
        }

    </script>
</body>

</html>
