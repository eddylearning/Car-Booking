@extends('user.layouts.user')

@section('content')
<div class="container">
    <h2 class="mb-4">Book {{ $car->name }}</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Car:</strong> {{ $car->name }}</p>
            <p><strong>Price per day:</strong> KES {{ number_format($car->price_per_day) }}</p>
        </div>
    </div>

    <form action="{{ route('user.bookings.store') }}" method="POST">
        @csrf

        <input type="hidden" name="car_id" value="{{ $car->id }}">

        <div class="mb-3">
            <label class="form-label">Start Date</label>
            <input type="date"
                   name="start_date"
                   class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">End Date</label>
            <input type="date"
                   name="end_date"
                   class="form-control"
                   required>
        </div>

        <button type="submit" class="btn btn-primary">
            Submit Booking Request
        </button>

        <a href="{{ route('user.cars.index') }}"
           class="btn btn-secondary ms-2">
            Cancel
        </a>
    </form>
</div>
@endsection
