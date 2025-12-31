@extends('employee.layouts.employee')

@section('content')
<div class="container">

    <h3 class="mb-3">
        Booking #{{ $booking->id }} — {{ $booking->car->name ?? '' }}
    </h3>

    {{-- Booking Info --}}
    <div class="alert alert-light">
        <strong>User:</strong> {{ $booking->user->name }} |
        <strong>Phone:</strong> {{ $booking->user->phone ?? 'N/A' }} |
        <strong>Status:</strong> {{ ucfirst($booking->status) }}
    </div>

    {{-- Messages --}}
    <div class="card mb-4">
        <div class="card-body" style="max-height: 400px; overflow-y: auto;">
            @foreach($messages as $msg)
                <div class="mb-3">
                    <strong>
                        {{ ucfirst($msg->sender_role) }}
                    </strong>

                    <div class="p-2 rounded
                        @if($msg->sender_role === 'system') bg-warning
                        @elseif($msg->sender_role === 'employee') bg-primary text-white
                        @else bg-light
                        @endif
                    ">
                        {{ $msg->message }}
                    </div>

                    <small class="text-muted">
                        {{ $msg->created_at->diffForHumans() }}
                    </small>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Employee Reply --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="POST" action="{{ route('employee.messages.store') }}">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                <textarea name="message"
                          class="form-control mb-2"
                          rows="3"
                          placeholder="Reply to user..."
                          required></textarea>

                <button class="btn btn-primary">
                    Send Message
                </button>
            </form>
        </div>
    </div>

    {{-- Actions --}}
    <div class="d-flex gap-2">

        {{-- Confirm Availability --}}
        @if($booking->status === 'pending')
            <form method="POST"
                  action="{{ route('employee.messages.confirm', $booking->id) }}">
                @csrf
                <button class="btn btn-success">
                    Confirm Availability
                </button>
            </form>
        @endif

        {{-- Send STK Push --}}
        @if($booking->status === 'approved')
            <form method="POST"
                  action="{{ route('employee.messages.stk') }}">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                <input type="text"
                       name="phone"
                       class="form-control mb-2"
                       placeholder="2547XXXXXXXX"
                       required>

                <button class="btn btn-warning">
                    Send STK Push
                </button>
            </form>
        @endif

    </div>

</div>
@endsection
