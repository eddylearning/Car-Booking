<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bookings Report</title>

    <style>
        body { font-family: "DejaVu Sans", sans-serif; font-size: 12px; }
        h2 { margin-bottom: 10px; }
        table {
            width: 100%; border-collapse: collapse; margin-top: 15px;
        }
        th, td {
            border: 1px solid #444; padding: 6px; text-align: left;
        }
        th { background: #e5e7eb; }
    </style>
</head>

<body>

<h2>Car Booking Report</h2>
<p>Generated on: {{ now()->format('d M Y H:i') }}</p>

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>User</th>
        <th>Car</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Total Price</th>
        <th>Status</th>
    </tr>
    </thead>

    <tbody>
    @foreach ($bookings as $b)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $b->user->name }}</td>
            <td>{{ $b->car->model }}</td>
            <td>{{ $b->start_date }}</td>
            <td>{{ $b->end_date }}</td>
            <td>KES {{ number_format($b->total_price) }}</td>
            <td>{{ ucfirst($b->status) }}</td>
        </tr>
    @endforeach
    </tbody>

</table>

</body>
</html>
