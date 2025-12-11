<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Booking</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <nav>
        <ul>
            <!-- Public Links -->
            <li><a href="{{ route('home') }}">Home</a></li>

            <!-- Guest Links -->
            @guest
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
            @endguest

            <!-- Authenticated User Links -->
            @auth
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </li>

                <!-- Role-based Dashboards -->
                @role('admin')
                    <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                @elserole('employee')
                    <li><a href="{{ route('employee.dashboard') }}">Employee Dashboard</a></li>
                @elserole('user')
                    <li><a href="{{ route('user.dashboard') }}">User Dashboard</a></li>
                @endrole
            @endauth
        </ul>
    </nav>

    <main>
        <h1>Welcome to Car Booking System</h1>
        <p>Choose an option from the menu above.</p>
    </main>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
