@extends('layouts.app')

@section('content')
<div class="container">

    <h3>
        Booking #{{ $booking->id }} — {{ $booking->car->name ?? '' }}
    </h3>

    <div class="alert alert-secondary">
        <strong>User:</strong> {{ $booking->user->name }} |
        <strong>Status:</strong> {{ ucfirst($booking->status) }}
    </div>

    {{-- Messages --}}
    <div class="card mb-4">
        <div class="card-body" style="max-height: 400px; overflow-y: auto;">
            @foreach($messages as $msg)
                <div class="mb-3">
                    <strong>{{ ucfirst($msg->sender_role) }}</strong>

                    <div class="p-2 rounded
                        @if($msg->sender_role === 'system') bg-warning
                        @elseif($msg->sender_role === 'admin') bg-dark text-white
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

    {{-- Admin Reply --}}
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.messages.store') }}">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                <textarea name="message"
                          class="form-control mb-2"
                          rows="3"
                          placeholder="Admin note / instruction..."
                          required></textarea>

                <button class="btn btn-dark">
                    Send Admin Message
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
