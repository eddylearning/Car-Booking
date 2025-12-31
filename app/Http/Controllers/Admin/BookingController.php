<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Show all bookings
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'car'])->latest()->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show a single booking
     */
    public function show($id)
    {
        $booking = Booking::with(['user', 'car'])->findOrFail($id);

        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show form to edit booking
     */
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);

        return view('admin.bookings.edit', compact('booking'));
    }

    /**
     * Update booking status
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,approved,cancelled,completed',
        ]);

        $booking->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking updated successfully.');
    }
}
