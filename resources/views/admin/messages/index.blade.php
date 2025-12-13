@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">All Booking Conversations</h2>

    <div class="list-group">
        @foreach($bookings as $booking)
            <a href="{{ route('admin.messages.show', $booking->id) }}"
               class="list-group-item list-group-item-action d-flex justify-content-between">

                <div>
                    <strong>Booking #{{ $booking->id }}</strong><br>
                    <small>
                        User: {{ $booking->user->name ?? 'N/A' }} |
                        Car: {{ $booking->car->name ?? 'N/A' }}
                    </small>
                </div>

                <span class="badge bg-dark">
                    {{ ucfirst($booking->status) }}
                </span>
            </a>
        @endforeach
    </div>
</div>
@endsection
