@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">All Bookings</h2>

    @if($bookings->isEmpty())
        <div class="alert alert-info">
            No bookings found.
        </div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Car</th>
                    <th>Status</th>
                    <th>Total Price</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->user->name }}</td>
                        <td>{{ $booking->car->name }}</td>
                        <td>{{ ucfirst($booking->status) }}</td>
                        <td>${{ number_format($booking->total_price, 2) }}</td>
                        <td>{{ $booking->start_date }}</td>
                        <td>{{ $booking->end_date }}</td>
                        <td>
                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-primary">View</a>
                            <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
