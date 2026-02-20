<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Payment;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     * This uses the layout: resources/views/layouts/admin.blade.php
     */
    public function dashboard()
    {
        // Stats for the admin dashboard
        $totalUsers = User::count();
        $totalCars = Car::count();
        $totalBookings = Booking::count();
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalCars',
            'totalBookings',
            'totalRevenue'
        ));
    }
}
