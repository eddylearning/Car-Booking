<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;

class EmployeeController extends Controller
{
    /**
     * Show the employee dashboard.
     * This uses layout: resources/views/layouts/employee.blade.php
     */
    public function dashboard()
    {
        $pendingBookings = Booking::where('status', 'pending')->count();
        $approvedBookings = Booking::where('status', 'approved')->count();
        $completedPayments = Payment::where('status', 'completed')->count();

        return view('employee.dashboard', compact(
            'pendingBookings',
            'approvedBookings',
            'completedPayments'
        ));
    }
}
