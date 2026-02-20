@extends('employee.layouts.employee')

@section('content')
<div class="container mt-5">
    <h2>Test Mpesa STK Push</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        <pre>{{ print_r(session('mpesa_response'), true) }}</pre>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('employee.payments.test.stk') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Phone Number (2547XXXXXXXX)</label>
            <input type="text" name="phone" class="form-control" required placeholder="2547XXXXXXXX">
        </div>

        <button class="btn btn-primary">Send STK Push</button>
    </form>
</div>
@endsection
