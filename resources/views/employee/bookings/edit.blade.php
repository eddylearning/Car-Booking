@extends('employee.layouts.employee')

@section('content')
<div class="container mt-4">
    <h3>Edit Booking #{{ $booking->id }}</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employee.bookings.update', $booking) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                @foreach(['pending','approved','rejected','completed'] as $status)
                    <option value="{{ $status }}" {{ $booking->status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Booking</button>
        <a href="{{ route('employee.bookings.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
