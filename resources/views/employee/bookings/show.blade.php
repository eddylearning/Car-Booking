@extends('employee.layouts.employee')

@section('content')
<div class="container mt-4">
    <h3>Booking Details #{{ $booking->id }}</h3>

    <table class="table table-bordered">
        <tr>
            <th>User</th>
            <td>{{ $booking->user->name }}</td>
        </tr>
        <tr>
            <th>Car</th>
            <td>{{ $booking->car->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Start Date</th>
            <td>{{ $booking->start_date }}</td>
        </tr>
        <tr>
            <th>End Date</th>
            <td>{{ $booking->end_date }}</td>
        </tr>
        <tr>
            <th>Location</th>
            <td>{{ $booking->location }}</td>
        </tr>
        <tr>
            <th>Total Price</th>
            <td>{{ $booking->total_price }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ ucfirst($booking->status) }}</td>
        </tr>
    </table>

    <a href="{{ route('employee.bookings.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
