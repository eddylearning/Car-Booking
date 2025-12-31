@extends('user.layouts.user')

@section('content')
<div class="container">
    <h2 class="mb-4">Create Booking for {{ $car->name }}</h2>

    <form action="{{ route('bookings.store') }}" method="POST">
        @csrf

        <input type="hidden" name="car_id" value="{{ $car->id }}">

        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" name="phone" class="form-control" placeholder="Enter phone number for payment" required>
        </div>

        <button type="submit" class="btn btn-primary">Book Car</button>
    </form>
</div>
@endsection
