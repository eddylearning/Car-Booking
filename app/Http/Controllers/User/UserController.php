<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Payment;

class UserController extends Controller
{
    /**
     * Show the user dashboard.
     * This uses layout: resources/views/layouts/user.blade.php
     */
    public function dashboard()
    {
        $myBookings = Booking::where('user_id', auth()->id())->count();
        $carsAvailable = Car::where('available', true)->count();
        $pendingPayments = Payment::whereHas('booking', function ($query) {
            $query->where('user_id', auth()->id());
        })->where('status', 'pending')->count();

        return view('user.dashboard', compact('myBookings', 'carsAvailable', 'pendingPayments'));
    }
}
