@extends('admin.layouts.admin')

@section('content')
<div class="container">

    <h3 class="mb-4">Payments</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($payments->isEmpty())
        <div class="alert alert-info">
            No payments found.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Car</th>
                        <th>Phone</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th width="140">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td>{{ $payment->id }}</td>
                            <td>
                                {{ $payment->booking->user->name ?? 'N/A' }}<br>
                                <small>{{ $payment->booking->user->email ?? '' }}</small>
                            </td>
                            <td>
                                {{ $payment->booking->car->name ?? 'N/A' }}
                            </td>
                            <td>{{ $payment->phone }}</td>
                            <td>KES {{ number_format($payment->amount) }}</td>
                            <td>
                                <span class="badge
                                    @if($payment->status === 'completed') bg-success
                                    @elseif($payment->status === 'pending') bg-warning
                                    @else bg-secondary
                                    @endif">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td>{{ $payment->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.payments.show', $payment) }}"
                                   class="btn btn-sm btn-primary">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $payments->links() }}
    @endif

</div>
@endsection
