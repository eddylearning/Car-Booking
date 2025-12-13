<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesBookingMessages;
use App\Models\Booking;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    use HandlesBookingMessages;

    /**
     * Admin inbox – all booking conversations
     */
    public function index()
    {
        $bookings = Booking::with(['messages', 'user', 'car'])
            ->latest()
            ->get();

        return view('admin.messages.index', compact('bookings'));
    }

    /**
     * Show conversation for a booking
     */
    public function show($bookingId)
    {
        $booking = Booking::with(['user', 'car'])
            ->findOrFail($bookingId);

        $messages = $this->getConversation($bookingId);

        return view('admin.messages.show', compact('booking', 'messages'));
    }

    /**
     * Admin sends a message (optional intervention)
     */
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'message'    => 'required|string',
        ]);

        $this->sendMessage(
            $request->booking_id,
            auth()->id(),
            'admin',
            $request->message
        );

        return back()->with('success', 'Admin message sent.');
    }
}
