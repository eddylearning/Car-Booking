<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    // Show all bookings for employee dashboard
    public function index()
    {
        $bookings = Booking::orderBy('created_at', 'desc')->get();

        return view('employee.bookings.index', compact('bookings'));
    }

    // Show the form to create a new booking
    public function create()
    {
        return view('employee.bookings.create');
    }

    // Store a new booking
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'car_model' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        Booking::create([
            'customer_name' => $request->customer_name,
            'car_model' => $request->car_model,
            'date' => $request->date,
            'status' => 'pending',
        ]);

        return redirect()->route('employee.bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    // Show a single booking details
    public function show($id)
    {
        $booking = Booking::findOrFail($id);

        return view('employee.bookings.show', compact('booking'));
    }

    // Show the form to edit a booking
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);

        return view('employee.bookings.edit', compact('booking'));
    }

    // Update a booking
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'car_model' => 'required|string|max:255',
            'date' => 'required|date',
            'status' => 'required|in:pending,approved,completed',
        ]);

        $booking->update($request->only('customer_name', 'car_model', 'date', 'status'));

        return redirect()->route('employee.bookings.index')
            ->with('success', 'Booking updated successfully.');
    }

    // Delete a booking
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('employee.bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }
}
