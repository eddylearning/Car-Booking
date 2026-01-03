@extends('user.layouts.user')

@section('content')
<div class="container">
    <h2 class="mb-4">My Bookings</h2>

    @if($bookings->isEmpty())
        <div class="alert alert-info">
            You have no bookings yet.
        </div>
    @else
        <div class="list-group">
            @foreach($bookings as $booking)
                <a href="{{ route('user.bookings.show', $booking->id) }}"
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">

                    <div>
                        <strong>Booking #{{ $booking->id }}</strong><br>
                        <small>
                            Car: {{ $booking->car->name ?? 'N/A' }} <br>
                            Status: {{ ucfirst($booking->status) }}
                        </small>
                    </div>

                    <span class="badge bg-primary">
                        KES{{ number_format($booking->total_price, 2) }} <!--the 2 adds two decimal places -->
                    </span>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
