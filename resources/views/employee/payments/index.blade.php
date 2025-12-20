@extends('employee.layouts.employee')
@section('content')
<h1>Payments</h1>

@if(session('success')) <div>{{ session('success') }}</div> @endif
@if(session('error')) <div>{{ session('error') }}</div> @endif

<table>
    <thead>
        <tr>
            <th>Booking</th>
            <th>User</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $payment)
        <tr>
            <td>{{ $payment->booking->id }}</td>
            <td>{{ $payment->booking->user->name }}</td>
            <td>{{ $payment->amount }}</td>
            <td>{{ $payment->status }}</td>
            <td>
                @if($payment->status !== 'completed')
                <form method="POST" action="{{ route('employee.payments.pay', $payment->booking) }}">
                    @csrf
                    <button type="submit">Send STK Push</button>
                </form>
                @else
                Paid
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $payments->links() }}
@endsection
