@extends('admin.layouts.admin')

@section('content')
<div class="container">

    <h3 class="mb-4">Payment Details</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            Payment #{{ $payment->id }}
        </div>
        <div class="card-body">

            <p><strong>Status:</strong>
                <span class="badge
                    @if($payment->status === 'completed') bg-success
                    @elseif($payment->status === 'pending') bg-warning
                    @else bg-secondary
                    @endif">
                    {{ ucfirst($payment->status) }}
                </span>
            </p>

            <p><strong>Amount:</strong> KES {{ number_format($payment->amount) }}</p>
            <p><strong>Phone:</strong> {{ $payment->phone }}</p>
            <p><strong>Date:</strong> {{ $payment->created_at->toDayDateTimeString() }}</p>

            <hr>

            <h5>Booking Details</h5>
            <p><strong>Booking ID:</strong> #{{ $payment->booking->id }}</p>
            <p><strong>Car:</strong> {{ $payment->booking->car->name ?? 'N/A' }}</p>
            <p><strong>Total Price:</strong> KES {{ number_format($payment->booking->total_price) }}</p>
            <p><strong>Booking Status:</strong> {{ ucfirst($payment->booking->status) }}</p>

            <hr>

            <h5>User Details</h5>
            <p><strong>Name:</strong> {{ $payment->booking->user->name }}</p>
            <p><strong>Email:</strong> {{ $payment->booking->user->email }}</p>

        </div>
    </div>

    @if($payment->status !== 'completed')
        <form method="POST"
              action="{{ route('admin.payments.complete', $payment) }}"
              onsubmit="return confirm('Mark payment as completed?')">
            @csrf
            <button class="btn btn-success">
                Mark as Completed
            </button>
        </form>
    @endif

    <a href="{{ route('admin.payments.index') }}"
       class="btn btn-secondary mt-3">
        Back to Payments
    </a>

</div>
@endsection
