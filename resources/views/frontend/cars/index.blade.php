@extends('layouts.frontend')

@section('content')

<section class="cars">
    <h3>Available Cars</h3>

    <div class="car-grid">
        @foreach($cars as $car)
            <div class="car-card">
                <img src="{{ $car->image ?? asset('images/car-placeholder.jpg') }}">
                <h4>{{ $car->name }}</h4>
                <p>KES {{ number_format($car->price_per_day, 2) }} / day</p>
            </div>
        @endforeach
    </div>

    {{ $cars->links() }}
</section>

@endsection
