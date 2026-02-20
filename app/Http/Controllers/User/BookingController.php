<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * List user's bookings
     */
    public function index()
    {
        $bookings = Booking::with('car')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.bookings.index', compact('bookings'));
    }

    /**
     * Show booking creation form
     */
    public function create(Car $car)
    {
        return view('user.bookings.create', compact('car'));
    }

    /**
     * Store new booking
     */
    public function store(Request $request)
    {
        $request->validate([
            'car_id'     => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'location'   => 'required|string|max:255',
        ]);

        $car = Car::findOrFail($request->car_id);

        $booking = Booking::create([
            'user_id'     => Auth::id(),
            'car_id'      => $car->id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'location'    => $request->location,
            'total_price' => $car->price_per_day * ( (strtotime($request->end_date) - strtotime($request->start_date)) / 86400 + 1 ),
            'status'      => 'pending',
        ]);

        return redirect()->route('user.bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    /**
     * Show a single booking
     */
    public function show($id)
    {
        $booking = Booking::with('car')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('user.bookings.show', compact('booking'));
    }
}
