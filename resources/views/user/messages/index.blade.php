@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">My Booking Messages</h2>

    @if($bookings->isEmpty())
        <div class="alert alert-info">
            You have no booking conversations yet.
        </div>
    @else
        <div class="list-group">
            @foreach($bookings as $booking)
                <a href="{{ route('user.messages.show', $booking->id) }}"
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">

                    <div>
                        <strong>Booking #{{ $booking->id }}</strong><br>
                        <small>
                            Car: {{ $booking->car->name ?? 'N/A' }}
                        </small>
                    </div>

                    <span class="badge bg-primary">
                        {{ $booking->messages->count() }} messages
                    </span>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
