@extends('layouts.user')

@section('content')
<div class="container">

    <h2 class="mb-4">User Dashboard</h2>

    <div class="row">

        {{-- Available Cars --}}
        <div class="col-md-4 mb-3">
            <div class="card p-4 shadow-sm">
                <h5>Available Cars</h5>
                <h2>{{ $carsAvailable ?? 0 }}</h2>
            </div>
        </div>

        {{-- My Bookings --}}
        <div class="col-md-4 mb-3">
            <div class="card p-4 shadow-sm">
                <h5>My Bookings</h5>
                <h2>{{ $myBookings ?? 0 }}</h2>
            </div>
        </div>

        {{-- Pending Payments --}}
        <div class="col-md-4 mb-3">
            <div class="card p-4 shadow-sm">
                <h5>Pending Payments</h5>
                <h2>{{ $pendingPayments ?? 0 }}</h2>
            </div>
        </div>

    </div>

</div>
@endsection
