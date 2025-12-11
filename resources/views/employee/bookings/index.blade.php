@extends('employee.layouts.employee')

@section('content')
<div class="container mt-4">
    <h3>Bookings</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('employee.bookings.create') }}" class="btn btn-primary mb-3">Add New Booking</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Car Model</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->id }}</td>
                <td>{{ $booking->customer_name }}</td>
                <td>{{ $booking->car_model }}</td>
                <td>{{ $booking->date }}</td>
                <td>{{ $booking->status }}</td>
                <td>
                    <a href="{{ route('employee.bookings.show', $booking->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('employee.bookings.edit', $booking->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('employee.bookings.destroy', $booking->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete booking?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
