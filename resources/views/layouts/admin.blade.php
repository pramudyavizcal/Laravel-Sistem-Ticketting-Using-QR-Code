<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $siteName . ' System') — Admin Panel</title>
    <link rel="icon" href="{{ $siteFaviconUrl }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #6C63FF;
            --primary-dark: #574fd6;
            --primary-light: #ede9ff;
            --success: #10b981;
            --success-light: #d1fae5;
            --warning: #f59e0b;
            --warning-light: #fef3c7;
            --danger: #ef4444;
            --danger-light: #fee2e2;
            --info: #3b82f6;
            --info-light: #dbeafe;

            /* Light theme tokens */
            --bg: #f4f6fb;
            --bg-2: #eef0f8;
            --surface: #ffffff;
            --surface-2: #f8f9fc;
            --border: #e5e7f0;
            --border-2: #d1d5e8;
            --text: #1e1e3a;
            --text-secondary: #4b5070;
            --text-muted: #8b90b0;

            /* Sidebar */
            --sidebar-bg: #ffffff;
            --sidebar-width: 256px;
            --header-height: 64px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            font-size: 14px;
        }

        /* ─── SIDEBAR ─────────────────────────────────────────── */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 100;
            transition: transform .3s ease;
            box-shadow: 2px 0 20px rgba(0, 0, 0, .05);
        }

        .sidebar-brand {
            padding: 1.25rem 1.25rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--primary), #a78bfa);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(108, 99, 255, .3);
        }

        .brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 10px;
        }

        .brand-name {
            font-size: .92rem;
            font-weight: 800;
            color: var(--text);
            line-height: 1.2;
        }

        .brand-sub {
            font-size: .68rem;
            color: var(--text-muted);
        }

        .sidebar-nav {
            flex: 1;
            padding: .75rem 0;
            overflow-y: auto;
        }

        .nav-section-label {
            font-size: .62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: var(--text-muted);
            padding: .875rem 1.25rem .3rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: .65rem;
            padding: .6rem 1.25rem;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: .838rem;
            font-weight: 500;
            transition: all .15s;
            position: relative;
            margin: 1px .5rem;
            border-radius: 8px;
        }

        .nav-item:hover {
            color: var(--primary);
            background: var(--primary-light);
        }

        .nav-item.active {
            color: var(--primary);
            background: var(--primary-light);
            font-weight: 700;
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: -8px;
            top: 6px;
            bottom: 6px;
            width: 3px;
            background: var(--primary);
            border-radius: 0 3px 3px 0;
        }

        .nav-item i {
            width: 18px;
            text-align: center;
            font-size: .85rem;
        }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid var(--border);
            background: var(--surface-2);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: .75rem;
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            background: linear-gradient(135deg, var(--primary), #a78bfa);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: .82rem;
            color: #fff;
            flex-shrink: 0;
        }

        .user-name {
            font-size: .82rem;
            font-weight: 700;
            color: var(--text);
        }

        .user-role {
            font-size: .7rem;
            color: var(--text-muted);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: .5rem;
            width: 100%;
            padding: .5rem .875rem;
            background: var(--danger-light);
            border: 1px solid #fecaca;
            color: var(--danger);
            border-radius: 8px;
            font-size: .78rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
            justify-content: center;
        }

        .btn-logout:hover {
            background: #fecaca;
        }

        /* ─── MAIN ────────────────────────────────────────────── */
        .main {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            height: var(--header-height);
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 1px 8px rgba(0, 0, 0, .05);
        }

        .page-title {
            font-size: 1rem;
            font-weight: 800;
            color: var(--text);
        }

        .page-breadcrumb {
            font-size: .72rem;
            color: var(--text-muted);
            margin-top: 1px;
        }

        .header-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .content {
            padding: 1.5rem;
            flex: 1;
        }

        /* ─── BUTTONS ─────────────────────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .5rem 1rem;
            border-radius: 8px;
            font-size: .82rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
            white-space: nowrap;
            font-family: 'Inter', sans-serif;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 2px 8px rgba(108, 99, 255, .25);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            box-shadow: 0 4px 14px rgba(108, 99, 255, .35);
            transform: translateY(-1px);
        }

        .btn-success {
            background: var(--success);
            color: #fff;
            box-shadow: 0 2px 8px rgba(16, 185, 129, .25);
        }

        .btn-success:hover {
            opacity: .9;
            transform: translateY(-1px);
        }

        .btn-danger {
            background: var(--danger);
            color: #fff;
            box-shadow: 0 2px 8px rgba(239, 68, 68, .2);
        }

        .btn-danger:hover {
            opacity: .9;
            transform: translateY(-1px);
        }

        .btn-warning {
            background: var(--warning);
            color: #fff;
            box-shadow: 0 2px 8px rgba(245, 158, 11, .2);
        }

        .btn-warning:hover {
            opacity: .9;
        }

        .btn-outline {
            background: var(--surface);
            border: 1.5px solid var(--border-2);
            color: var(--text-secondary);
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-light);
        }

        .btn-sm {
            padding: .35rem .75rem;
            font-size: .76rem;
        }

        .btn-lg {
            padding: .7rem 1.4rem;
            font-size: .92rem;
        }

        /* ─── CARDS ───────────────────────────────────────────── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .05);
        }

        .card-header {
            padding: .875rem 1.25rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--surface-2);
        }

        .card-title {
            font-size: .9rem;
            font-weight: 700;
            color: var(--text);
        }

        .card-body {
            padding: 1.25rem;
        }

        /* ─── STAT CARDS ──────────────────────────────────────── */
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.25rem;
            position: relative;
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .05);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, .1);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
        }

        .stat-card.purple::before {
            background: linear-gradient(90deg, #6C63FF, #a78bfa);
        }

        .stat-card.cyan::before {
            background: linear-gradient(90deg, #06b6d4, #38bdf8);
        }

        .stat-card.red::before {
            background: linear-gradient(90deg, #ef4444, #f87171);
        }

        .stat-card.green::before {
            background: linear-gradient(90deg, #10b981, #6ee7b7);
        }

        .stat-card.orange::before {
            background: linear-gradient(90deg, #f59e0b, #fbbf24);
        }

        .stat-card.blue::before {
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: .75rem;
        }

        .stat-value {
            font-size: 1.9rem;
            font-weight: 800;
            color: var(--text);
            line-height: 1;
        }

        .stat-label {
            font-size: .78rem;
            color: var(--text-muted);
            margin-top: .3rem;
        }

        .stat-sub {
            font-size: .73rem;
            color: var(--text-muted);
            margin-top: .4rem;
        }

        /* ─── TABLE ───────────────────────────────────────────── */
        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: .838rem;
        }

        thead th {
            padding: .7rem 1rem;
            text-align: left;
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
            background: var(--surface-2);
        }

        tbody td {
            padding: .825rem 1rem;
            border-bottom: 1px solid var(--border);
            color: var(--text-secondary);
            vertical-align: middle;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover td {
            background: var(--bg);
        }

        /* ─── BADGES ──────────────────────────────────────────── */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: .2rem;
            padding: .2rem .6rem;
            border-radius: 20px;
            font-size: .7rem;
            font-weight: 700;
        }

        .badge-success {
            background: var(--success-light);
            color: #065f46;
        }

        .badge-warning {
            background: var(--warning-light);
            color: #92400e;
        }

        .badge-danger {
            background: var(--danger-light);
            color: #991b1b;
        }

        .badge-info {
            background: var(--info-light);
            color: #1e40af;
        }

        .badge-purple {
            background: var(--primary-light);
            color: #4c1d95;
        }

        /* ─── FORMS ───────────────────────────────────────────── */
        .form-group {
            margin-bottom: 1.1rem;
        }

        .form-label {
            display: block;
            font-size: .8rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: .35rem;
        }

        .form-control {
            width: 100%;
            padding: .6rem .875rem;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            font-size: .875rem;
            transition: border-color .15s, box-shadow .15s;
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(108, 99, 255, .12);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .form-control option {
            background: var(--surface);
            color: var(--text);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 90px;
        }

        .form-row {
            display: grid;
            gap: 1rem;
        }

        .form-row.cols-2 {
            grid-template-columns: 1fr 1fr;
        }

        .form-row.cols-3 {
            grid-template-columns: 1fr 1fr 1fr;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: .5rem;
            cursor: pointer;
        }

        .form-check input {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .form-check label {
            font-size: .875rem;
            font-weight: 500;
            color: var(--text);
            cursor: pointer;
        }

        /* ─── ALERTS ──────────────────────────────────────────── */
        .alert {
            padding: .825rem 1.1rem;
            border-radius: 8px;
            font-size: .852rem;
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: var(--success-light);
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .alert-danger {
            background: var(--danger-light);
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .alert-warning {
            background: var(--warning-light);
            border: 1px solid #fde68a;
            color: #92400e;
        }

        .alert-info {
            background: var(--info-light);
            border: 1px solid #bfdbfe;
            color: #1e40af;
        }

        /* ─── EVENT TYPE CHIPS ────────────────────────────────── */
        .type-chip {
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            padding: .2rem .6rem;
            border-radius: 20px;
            font-size: .72rem;
            font-weight: 700;
        }

        .type-wisuda {
            background: #ede9ff;
            color: #5b21b6;
        }

        .type-seminar {
            background: #e0f2fe;
            color: #0369a1;
        }

        .type-konser {
            background: #fee2e2;
            color: #991b1b;
        }

        .type-workshop {
            background: #dcfce7;
            color: #166534;
        }

        /* ─── GRID ────────────────────────────────────────────── */
        .grid {
            display: grid;
            gap: 1rem;
        }

        .grid-2 {
            grid-template-columns: repeat(2, 1fr);
        }

        .grid-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .grid-4 {
            grid-template-columns: repeat(4, 1fr);
        }

        /* ─── FLEX UTILS ──────────────────────────────────────── */
        .d-flex {
            display: flex;
        }

        .align-center {
            align-items: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .gap-1 {
            gap: .5rem;
        }

        .gap-2 {
            gap: 1rem;
        }

        .mt-1 {
            margin-top: .5rem;
        }

        .mt-2 {
            margin-top: 1rem;
        }

        .mt-3 {
            margin-top: 1.5rem;
        }

        .mb-1 {
            margin-bottom: .5rem;
        }

        .mb-2 {
            margin-bottom: 1rem;
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-muted {
            color: var(--text-muted);
            font-size: .82rem;
        }

        .text-sm {
            font-size: .8rem;
        }

        .fw-bold {
            font-weight: 700;
        }

        /* ─── PAGINATION ──────────────────────────────────────── */
        .pagination {
            display: flex;
            gap: .25rem;
            align-items: center;
            margin-top: 1rem;
        }

        .pagination .page-link {
            padding: .38rem .7rem;
            border-radius: 6px;
            border: 1.5px solid var(--border);
            color: var(--text-secondary);
            text-decoration: none;
            font-size: .78rem;
            font-weight: 500;
            transition: all .15s;
            background: var(--surface);
        }

        .pagination .page-link:hover,
        .pagination .active .page-link {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        .pagination .disabled .page-link {
            opacity: .4;
            cursor: not-allowed;
        }

        /* ─── SEARCH BAR ──────────────────────────────────────── */
        .search-input-wrap {
            position: relative;
            flex: 1;
            min-width: 180px;
        }

        .search-input-wrap i {
            position: absolute;
            left: .8rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: .8rem;
        }

        .search-input-wrap .form-control {
            padding-left: 2.2rem;
        }

        /* ─── MOBILE ──────────────────────────────────────────── */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main {
                margin-left: 0;
            }

            .grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }

            .grid-3 {
                grid-template-columns: 1fr 1fr;
            }

            .grid-2 {
                grid-template-columns: 1fr;
            }

            .form-row.cols-2,
            .form-row.cols-3 {
                grid-template-columns: 1fr;
            }
        }

        /* ─── SCROLLBAR ───────────────────────────────────────── */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border-2);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-muted);
        }
    </style>
    @stack('styles')
</head>

<body>

    <!-- ─── SIDEBAR ──────────────────────────────────────── -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">
                @if($siteLogoUrl)
                    <img src="{{ $siteLogoUrl }}" alt="{{ $siteName }}">
                @else
                    🎫
                @endif
            </div>
            <div>
                <div class="brand-name">{{ $siteName }}</div>
                <div class="brand-sub">Multi Event System</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            @if(auth()->user()->isSuperAdmin())
                <div class="nav-section-label">Overview</div>
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Dashboard
                </a>
                <a href="{{ route('admin.admin-users.index') }}"
                    class="nav-item {{ request()->routeIs('admin.admin-users.*') ? 'active' : '' }}">
                    <i class="fas fa-user-shield"></i> Admin
                </a>
            @endif

            <div class="nav-section-label">Manajemen</div>
            <a href="{{ route('admin.events.index') }}"
                class="nav-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i> Events
            </a>
            <a href="{{ route('admin.attendees.index') }}"
                class="nav-item {{ request()->routeIs('admin.attendees.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Peserta
            </a>

            <div class="nav-section-label">Operasional</div>
            <a href="{{ route('admin.scanner') }}"
                class="nav-item {{ request()->routeIs('admin.scanner') ? 'active' : '' }}">
                <i class="fas fa-qrcode"></i> QR Scanner
            </a>
            <a href="{{ route('admin.scan-logs') }}"
                class="nav-item {{ request()->routeIs('admin.scan-logs') ? 'active' : '' }}">
                <i class="fas fa-history"></i> Log Scan
            </a>

            <div class="nav-section-label">Akun</div>
            <a href="{{ route('admin.profile') }}"
                class="nav-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                <i class="fas fa-key"></i> Ganti Password
            </a>
            @if(auth()->user()->isSuperAdmin())
                <a href="{{ route('admin.settings.branding') }}"
                    class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fas fa-palette"></i> Branding
                </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                <div>
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- ─── MAIN ─────────────────────────────────────────── -->
    <div class="main">
        <header class="header">
            <button onclick="document.getElementById('sidebar').classList.toggle('open')"
                style="display:none;background:none;border:none;color:var(--text);font-size:1.2rem;cursor:pointer;margin-right:1rem"
                id="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <div>
                <div class="page-title">@yield('page-title', 'Dashboard')</div>
                <div class="page-breadcrumb">@yield('breadcrumb', 'Admin Panel')</div>
            </div>
            <div class="header-right">
                <span
                    style="font-size:.75rem;color:var(--text-muted);background:var(--bg);padding:.35rem .75rem;border-radius:20px;border:1px solid var(--border)">
                    <i class="fas fa-clock" style="color:var(--primary)"></i>
                    {{ now()->format('d M Y, H:i') }} WIB
                </span>
            </div>
        </header>

        <div class="content">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script>
        // Auto-hide alerts
        document.querySelectorAll('.alert').forEach(el => {
            setTimeout(() => {
                el.style.transition = 'opacity .5s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            }, 5000);
        });

        // Mobile sidebar
        const menuToggle = document.getElementById('menu-toggle');
        if (window.innerWidth <= 768) menuToggle.style.display = 'block';
        window.addEventListener('resize', () => {
            menuToggle.style.display = window.innerWidth <= 768 ? 'block' : 'none';
        });
    </script>
    @stack('scripts')
</body>

</html>
