<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function bookings()
{
    $bookings = Booking::with(['user','car'])->get();

    $pdf = Pdf::loadView('admin.reports.bookings', compact('bookings'));

    return $pdf->download('bookings-report.pdf');
}

public function payments()
{
    $payments = Payment::with(['user','car'])->get();

    $pdf = Pdf::loadView('admin.reports.payments', compact('payments'));

    return $pdf->download('payments-report.pdf');
}

public function revenue()
{
    $payments = Payment::with(['user','car'])
                ->where('status', 'completed')
                ->get();

    $totalRevenue = $payments->sum('amount');

    $pdf = Pdf::loadView('admin.reports.revenue', compact('payments','totalRevenue'));

    return $pdf->download('revenue-report.pdf');
}

}
