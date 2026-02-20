@extends('layouts.frontend')

@section('content')

<section class="hero">
    <div class="hero-content">
        <h2>Find & Book Your Perfect Ride</h2>
        <p>Explore our fleet of vehicles with transparent pricing and easy booking</p>

        <form class="search-bar" action="{{ route('cars.index') }}">
            <input type="text" name="q" placeholder="Search for cars...">
            <button type="submit">Search</button>
        </form>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="section-header">
            <h3>Our Latest Cars</h3>
            <div class="divider"></div>
        </div>

        @if($featuredCars->isEmpty())
            <p style="text-align:center;">No cars available yet. Add cars from the admin panel.</p>
        @else
            <div class="car-grid">
                @foreach($featuredCars as $car)
                    <div class="car-card">
                        <div class="card-image">
                            <img src="{{ $car->image_url }}" alt="{{ $car->name }}">
                        </div>
                        <div class="card-details">
                            <h4>{{ $car->name }}</h4>
                            <p class="price">KES {{ number_format($car->price_per_day, 2) }} <span>/ day</span></p>
                            <a href="{{ route('user.bookings.create', $car->id) }}" class="btn-book">
                                Book Now
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection
