@extends('employee.layouts.employee')

@section('content')
<h3 class="mb-4">Employee Dashboard</h3>

<div class="row">
    <div class="col-md-4">
        <div class="card p-3 shadow-sm">
            <h5>Pending Bookings</h5>
            <h2>{{ $pendingBookings }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 shadow-sm">
            <h5>Approved Bookings</h5>
            <h2>{{ $approvedBookings }}</h2>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 shadow-sm">
            <h5>Completed Payments</h5>
            <h2>{{ $completedPayments }}</h2>
        </div>
    </div>
</div>
@endsection
