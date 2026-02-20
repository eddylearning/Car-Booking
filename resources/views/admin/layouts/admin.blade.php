<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Car Booking</title>

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    {{-- Custom CSS --}}
    <style>
        :root {
            --app-bg: #f5f6fa;
            --app-text: #111827;
            --surface: #ffffff;
            --border: #e2e8f0;
            --sidebar-bg: #0f172a;
            --sidebar-link: #cbd5e1;
        }
        body {
            background: var(--app-bg);
            color: var(--app-text);
        }
        .sidebar {
            height: 100vh;
            background: var(--sidebar-bg);
            padding: 20px;
            color: white;
        }
        .sidebar a {
            display: block;
            color: var(--sidebar-link);
            padding: 10px 0;
            text-decoration: none;
            font-size: 15px;
        }
        .sidebar a:hover {
            color: #fff;
            padding-left: 4px;
            transition: .2s;
        }
        .content-area {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
        }
        .top-nav {
            background: var(--surface);
            padding: 12px 25px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .theme-toggle {
            min-width: 110px;
        }
        body.theme-dark {
            --app-bg: #0b1220;
            --app-text: #e5e7eb;
            --surface: #111827;
            --border: #374151;
            --sidebar-bg: #020617;
            --sidebar-link: #cbd5e1;
        }
        body.theme-dark .card,
        body.theme-dark .table,
        body.theme-dark .table td,
        body.theme-dark .table th,
        body.theme-dark .modal-content {
            background-color: #111827;
            color: #e5e7eb;
            border-color: #374151;
        }
        body.theme-dark .table-light,
        body.theme-dark .table-light > tr > th {
            background-color: #1f2937 !important;
            color: #e5e7eb !important;
        }
        body.theme-dark .btn-outline-secondary {
            color: #e5e7eb;
            border-color: #6b7280;
        }
    </style>
</head>

<body>

{{-- SIDEBAR --}}
<div class="sidebar position-fixed">
    <h4 class="mb-4">Admin Panel</h4>

    <a href="{{ route('admin.dashboard') }}">📊 Dashboard</a>

    <hr style="border-color: #334155">

    <a href="{{ route('admin.cars.index') }}">🚗 Cars</a>
    <a href="{{ route('admin.bookings.index') }}">📘 Bookings</a>
    <a href="{{ route('admin.payments.index') }}">💳 Payments</a>
    <a href="{{ route('admin.messages.index') }}">📩 Messages</a>
    <a href="{{ route('profile.edit') }}">Profile Settings</a>

    <hr style="border-color: #334155">

    <a href="{{ route('admin.reports.bookings') }}">📄 Booking Report</a>
    <a href="{{ route('admin.reports.payments') }}">📄 Payments Report</a>
    <a href="{{ route('admin.reports.revenue') }}">📄 Revenue Report</a>

    <hr style="border-color: #334155">

    <a href="/">🏠 Back to Site</a>

    <form action="{{ route('logout') }}" method="POST" class="mt-3">
        @csrf
        <button class="btn btn-danger w-100">Logout</button>
    </form>
</div>

{{-- CONTENT --}}
<div class="content-area">

    {{-- Top Nav --}}
    <div class="top-nav">
        <h5 class="m-0">Welcome, {{ auth()->user()->name }}</h5>
        <div class="d-flex align-items-center gap-2">
            <button id="themeToggle" type="button" class="btn btn-sm btn-outline-secondary theme-toggle" aria-label="Toggle theme">
                <span id="themeIcon" aria-hidden="true">🌙</span>
            </button>
            <img src="{{ auth()->user()->profile_photo_url ?? '/default.png' }}"
                 width="40" height="40" class="rounded-circle">
        </div>
    </div>

    {{-- Page Content --}}
    <div class="mt-4">
        @yield('content')
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (function () {
        const storageKey = 'carbooking-theme';
        const body = document.body;
        const toggleBtn = document.getElementById('themeToggle');

        if (!toggleBtn) {
            return;
        }

        const icon = document.getElementById('themeIcon');

        const applyTheme = (theme) => {
            if (theme === 'dark') {
                body.classList.add('theme-dark');
                if (icon) icon.textContent = '☀️';
            } else {
                body.classList.remove('theme-dark');
                if (icon) icon.textContent = '🌙';
            }
        };

        const saved = localStorage.getItem(storageKey);
        if (saved === 'dark' || saved === 'light') {
            applyTheme(saved);
        } else {
            applyTheme(window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        }

        toggleBtn.addEventListener('click', function () {
            const nextTheme = body.classList.contains('theme-dark') ? 'light' : 'dark';
            localStorage.setItem(storageKey, nextTheme);
            applyTheme(nextTheme);
        });
    })();
</script>
</body>
</html>
