{{-- <header class="header">
    <div class="container nav-container">
        <a href="{{ route('home') }}" class="logo">🚗 CarBooking</a>

        <ul class="nav-links">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('cars.index') }}">Cars</a></li>
            <li><a href="{{ route('about') }}">About</a></li>
            <li><a href="{{ route('contact') }}">Contact</a></li>

            @guest
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
            @endguest

            @auth
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="logout-btn">Logout</button>
                    </form>
                </li>
            @endauth
        </ul>
    </div>
</header> --}}


<header class="header">
    <div class="container nav-container">
        <a href="{{ route('home') }}" class="logo">🚗 CarBooking</a>

        <!-- Hamburger Menu Button for Mobile -->
        <button class="menu-toggle" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </button>

        <ul class="nav-links" id="navLinks">
            <li><a href="{{ route('home') }}" onclick="toggleMenu()">Home</a></li>
            <li><a href="{{ route('cars.index') }}" onclick="toggleMenu()">Cars</a></li>
            <li><a href="{{ route('about') }}" onclick="toggleMenu()">About</a></li>
            <li><a href="{{ route('contact') }}" onclick="toggleMenu()">Contact</a></li>

            @guest
                <li><a href="{{ route('login') }}" onclick="toggleMenu()">Login</a></li>
                <li><a href="{{ route('register') }}" onclick="toggleMenu()">Register</a></li>
            @endguest

            @auth
                <!-- Fix: Dynamic Dashboard Dropdown -->
                <li class="dropdown">
                    <button class="dropbtn">
                        My Account <i class="fas fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content">
                        
                        <!-- Check if user is ADMIN -->
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Admin Dashboard
                            </a>
                        
                        <!-- Check if user is EMPLOYEE -->
                        @elseif(auth()->user()->hasRole('employee'))
                            <a href="{{ route('employee.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Employee Dashboard
                            </a>
                        
                        <!-- Default to USER Dashboard -->
                        @else
                            <a href="{{ route('user.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        @endif
                        
                        <a href="{{ route('home') }}">
                            <i class="fas fa-home"></i> Back to Site
                        </a>

                        <!-- Logout Form -->
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-logout-btn">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
            @endauth
        </ul>
    </div>
</header>