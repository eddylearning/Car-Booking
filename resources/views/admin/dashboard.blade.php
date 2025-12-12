@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Admin Dashboard</h2>

    <div class="row">

        {{-- Total cars --}}
        <div class="col-md-4 mb-3">
            <div class="card p-4 shadow-sm">
                <h5>Total Cars</h5>
                <h2>{{ $totalCars ?? 0 }}</h2>
            </div>
        </div>

        {{-- Total Bookings --}}
        <div class="col-md-4 mb-3">
            <div class="card p-4 shadow-sm">
                <h5>Total Bookings</h5>
                <h2>{{ $totalBookings ?? 0 }}</h2>
            </div>
        </div>

        {{-- Revenue --}}
        <div class="col-md-4 mb-3">
            <div class="card p-4 shadow-sm">
                <h5>Total Revenue</h5>
                <h2>KES {{ number_format($totalRevenue ?? 0) }}</h2>
            </div>
        </div>

    </div>
</div>
@endsection
