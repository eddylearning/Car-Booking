@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Booking Conversations</h2>

    @if($bookings->isEmpty())
        <div class="alert alert-info">
            No booking messages yet.
        </div>
    @else
        <div class="list-group">
            @foreach($bookings as $booking)
                <a href="{{ route('employee.messages.show', $booking->id) }}"
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">

                    <div>
                        <strong>Booking #{{ $booking->id }}</strong><br>
                        <small>
                            User: {{ $booking->user->name ?? 'N/A' }} |
                            Car: {{ $booking->car->name ?? 'N/A' }}
                        </small>
                    </div>

                    <span class="badge bg-secondary">
                        {{ ucfirst($booking->status) }}
                    </span>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
