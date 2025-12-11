<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class UserController extends Controller
{
    /**
     * Show the user dashboard.
     * This uses layout: resources/views/layouts/user.blade.php
     */
    public function dashboard()
    {
        $myBookings = Booking::where('user_id', auth()->id())->count();

        return view('user.dashboard', compact('myBookings'));
    }
}
