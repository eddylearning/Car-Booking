@extends('layouts.frontend')

@section('content')

<section class="cars">
    <h3>Available Cars</h3>

    @if($cars->isEmpty())
        <p style="text-align:center;">No cars found.</p>
    @else
        <div class="car-grid">
            @foreach($cars as $car)
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

    {{ $cars->links() }}
</section>

@endsection
