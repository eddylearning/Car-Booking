<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Car Booking</title>

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body { background: #f5f6fa; }
        .sidebar {
            height: 100vh;
            background: #1e293b;
            padding: 20px;
            color: white;
        }
        .sidebar a {
            display: block;
            color: #e2e8f0;
            padding: 10px 0;
            text-decoration: none;
        }
        .sidebar a:hover {
            color: #fff;
            padding-left: 4px;
            transition: .2s;
        }
        .content-area {
            margin-left: 260px;
            padding: 30px;
        }
        .top-nav {
            background: white;
            padding: 12px 25px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>

<body>

{{-- SIDEBAR --}}
<div class="sidebar position-fixed">

    <h4 class="mb-4">User Panel</h4>

    <a href="{{ route('user.dashboard') }}">📊 Dashboard</a>
    <a href="{{ route('user.cars.index') }}">🚗 Browse Cars</a>
    <a href="{{ route('user.bookings.index') }}">📘 My Bookings</a>
    <a href="{{ route('user.messages.index') }}">📩 Messages</a>

    <hr style="border-color: #475569">

    <a href="/">🏠 Back to Site</a>

    <form action="{{ route('logout') }}" method="POST" class="mt-3">
        @csrf
        <button class="btn btn-danger w-100">Logout</button>
    </form>

</div>

{{-- MAIN CONTENT --}}
<div class="content-area">

    <div class="top-nav">
        <h5 class="m-0">Hello, {{ auth()->user()->name }}</h5>
        <img src="{{ auth()->user()->profile_photo_url ?? '/default.png' }}" 
             width="40" height="40" class="rounded-circle">
    </div>

    <div class="mt-4">
        @yield('content')
    </div>

</div>

</body>
</html>
