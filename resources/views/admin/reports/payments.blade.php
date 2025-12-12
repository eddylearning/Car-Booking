<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payments Report</title>

    <style>
        body { font-family: "DejaVu Sans", sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #444; padding: 6px; }
        th { background: #e5e7eb; }
    </style>
</head>

<body>

<h2>Payments Report</h2>
<p>Generated on: {{ now()->format('d M Y H:i') }}</p>

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>User</th>
        <th>Car</th>
        <th>Amount</th>
        <th>Phone</th>
        <th>Status</th>
        <th>Transaction ID</th>
        <th>Date</th>
    </tr>
    </thead>

    <tbody>
    @foreach ($payments as $p)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $p->user->name }}</td>
            <td>{{ $p->car->model }}</td>
            <td>KES {{ number_format($p->amount) }}</td>
            <td>{{ $p->phone }}</td>
            <td>{{ ucfirst($p->status) }}</td>
            <td>{{ $p->transaction_id }}</td>
            <td>{{ $p->created_at->format('d M Y') }}</td>
        </tr>
    @endforeach
    </tbody>

</table>

</body>
</html>
