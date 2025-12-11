@extends('employee.layouts.employee')

@section('content')
<div class="container mt-4">
    <h3>Create Booking</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employee.bookings.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>User ID</label>
            <input type="number" name="user_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Car ID</label>
            <input type="number" name="car_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="location" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Total Price</label>
            <input type="number" name="total_price" class="form-control" step="0.01" required>
        </div>

        <button type="submit" class="btn btn-success">Create Booking</button>
        <a href="{{ route('employee.bookings.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
