@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Booking #{{ $booking->id }}</h2>

    <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ $booking->status === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Booking</button>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
