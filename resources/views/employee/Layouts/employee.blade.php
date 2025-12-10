<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard - Car Booking</title>

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    {{-- Custom CSS --}}
    <style>
        body {
            background: #f5f6fa;
        }
        .sidebar {
            height: 100vh;
            background: #1f2937;
            padding: 20px;
            color: white;
        }
        .sidebar a {
            display: block;
            color: #d1d5db;
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
    <h4 class="mb-4">Employee Panel</h4>

    <a href="{{ route('employee.dashboard') }}">📊 Dashboard</a>

    <hr style="border-color: #4b5563">

    <a href="{{ route('employee.bookings.index') }}">📘 Bookings</a>

    <a href="{{ route('employee.messages.index') }}">📩 Messages</a>

    <a href="{{ route('employee.payments.index') }}">💳 Payments</a>

    <a href="{{ route('employee.payments.test') }}">⚡ Test Mpesa STK</a>

    <hr style="border-color: #4b5563">

    <a href="/">🏠 Back to Site</a>

    <form action="{{ route('logout') }}" method="POST" class="mt-3">
        @csrf
        <button class="btn btn-danger w-100">Logout</button>
    </form>
</div>

{{-- CONTENT AREA --}}
<div class="content-area">

    {{-- Top navbar --}}
    <div class="top-nav">
        <h5 class="m-0">Welcome, {{ auth()->user()->name }}</h5>
        <img src="{{ auth()->user()->profile_photo_url ?? '/default.png' }}" 
             width="40" height="40" class="rounded-circle">
    </div>

    {{-- Page content --}}
    <div class="mt-4">
        @yield('content')
    </div>

</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
