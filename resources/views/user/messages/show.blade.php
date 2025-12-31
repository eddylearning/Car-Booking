@extends('user.layouts.user')

@section('content')
<div class="container">

    <h3 class="mb-3">
        Booking #{{ $booking->id }} – Messages
    </h3>

    <div class="card mb-4">
        <div class="card-body" style="max-height: 400px; overflow-y: auto;">
            @forelse($messages as $msg)
                <div class="mb-3">

                    {{-- Sender label --}}
                    <strong>
                        @if($msg->sender_role === 'user')
                            You
                        @elseif($msg->sender_role === 'employee')
                            Employee
                        @elseif($msg->sender_role === 'admin')
                            Admin
                        @else
                            System
                        @endif
                    </strong>

                    <div class="p-2 rounded
                        @if($msg->sender_role === 'user') bg-light
                        @elseif($msg->sender_role === 'system') bg-warning
                        @else bg-secondary text-white
                        @endif
                    ">
                        {{ $msg->message }}
                    </div>

                    <small class="text-muted">
                        {{ $msg->created_at->diffForHumans() }}
                    </small>

                </div>
            @empty
                <p>No messages yet.</p>
            @endforelse
        </div>
    </div>

           <!--logic for yes no confirmation-->

    @if($booking->status === 'pending')
    <div class="mb-4 d-flex gap-3">

        <form method="POST" action="{{ route('user.messages.yes', $booking) }}">
            @csrf
            <button type="submit" class="btn btn-success">
                YES, Confirm Booking
            </button>
        </form>

        <form method="POST" action="{{ route('user.messages.no', $booking) }}">
            @csrf
            <button type="submit" class="btn btn-danger">
                NO, Reject Booking
            </button>
        </form>

    </div>
@endif

    {{-- Reply Form --}}
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('user.messages.store') }}">
                @csrf

                <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                <div class="mb-3">
                    <textarea name="message"
                              class="form-control"
                              rows="3"
                              placeholder="Type your message here (YES + phone / NO / question)"
                              required></textarea>
                </div>

                <button class="btn btn-primary">
                    Send Message
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
