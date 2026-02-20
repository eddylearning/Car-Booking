@extends('user.layouts.user')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-6">

            @if($car->image)
                <img src="{{ $car->image_url }}"
                     class="img-fluid rounded mb-3">
            @endif

        </div>

        <div class="col-md-6">

            <h3>{{ $car->name }}</h3>

            <p><strong>Model:</strong> {{ $car->model }}</p>
            <p><strong>Type:</strong> {{ $car->type }}</p>
            <p><strong>Mileage:</strong> {{ $car->mileage }} km</p>

            <p class="fs-5 fw-bold">
                KES {{ number_format($car->price_per_day) }} / day
            </p>

            @if($car->available)
                <a href="{{ route('user.bookings.create', $car) }}"
                   class="btn btn-primary">
                    Book This Car
                </a>
            @else
                <span class="badge bg-danger">
                    Not Available
                </span>
            @endif

            <a href="{{ route('user.cars.index') }}"
               class="btn btn-secondary ms-2">
                Back
            </a>

        </div>
    </div>

</div>
@endsection
