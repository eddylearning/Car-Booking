<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Revenue Report</title>

    <style>
        body { font-family: "DejaVu Sans", sans-serif; font-size: 12px; }
        h2 { margin-bottom: 10px; }
        .summary-box {
            padding: 10px;
            background: #e2e8f0;
            border: 1px solid #94a3b8;
            margin-bottom: 15px;
        }
        table {
            width: 100%; border-collapse: collapse; margin-top: 15px;
        }
        th, td {
            border: 1px solid #444; padding: 6px;
        }
        th { background: #e5e7eb; }
    </style>
</head>

<body>

<h2>Revenue Report</h2>
<p>Generated on: {{ now()->format('d M Y H:i') }}</p>

<div class="summary-box">
    <strong>Total Revenue:</strong>
    KES {{ number_format($totalRevenue) }}
</div>

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Car</th>
        <th>User</th>
        <th>Amount</th>
        <th>Date</th>
    </tr>
    </thead>

    <tbody>
    @foreach ($payments as $p)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $p->car->model }}</td>
            <td>{{ $p->user->name }}</td>
            <td>KES {{ number_format($p->amount) }}</td>
            <td>{{ $p->created_at->format('d M Y') }}</td>
        </tr>
    @endforeach
    </tbody>

</table>

</body>
</html>
