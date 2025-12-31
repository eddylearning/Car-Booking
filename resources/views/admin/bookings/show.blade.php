@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-3">Booking #{{ $booking->id }}</h2>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>User:</strong> {{ $booking->user->name }}</p>
            <p><strong>Car:</strong> {{ $booking->car->name }}</p>
            <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
            <p><strong>Total Price:</strong> ${{ number_format($booking->total_price, 2) }}</p>
            <p><strong>Start Date:</strong> {{ $booking->start_date }}</p>
            <p><strong>End Date:</strong> {{ $booking->end_date }}</p>
            <p><strong>Created At:</strong> {{ $booking->created_at->format('d-m-Y H:i') }}</p>
        </div>
    </div>

    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Back to Bookings</a>
</div>
@endsection
