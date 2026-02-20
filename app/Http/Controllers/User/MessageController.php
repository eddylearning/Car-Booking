<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesBookingMessages;
use App\Models\Booking;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    use HandlesBookingMessages;

    /**
     * Inbox – list of user bookings that have conversations
     */
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with('messages')
            ->latest()
            ->get();

        return view('user.messages.index', compact('bookings'));
    }

    /**
     * Show conversation for a specific booking
     */
    public function show($bookingId)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $messages = $this->getConversation($bookingId);

        return view('user.messages.show', compact('booking', 'messages'));
    }

    /**
     * Send a message from the user
     */
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'message'    => 'required|string',
        ]);

        // Ensure booking belongs to user
        $booking = Booking::where('id', $request->booking_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $this->sendMessage(
            $booking->id,
            auth()->id(),
            'user',
            $request->message
        );

        return back()->with('success', 'Message sent.');
    }

    public function confirmYes(Booking $booking)
    {
        if ((int) $booking->user_id !== (int) auth()->id()) {
            abort(403);
        }

        $booking->update([
            'status' => 'approved',
        ]);

        Message::create([
            'booking_id' => $booking->id,
            'sender_id' => auth()->id(),
            'sender_role' => 'user',
            'message' => 'User confirmed booking (YES)',
        ]);

        return redirect()->back()->with('success', 'Booking confirmed.');
    }

    public function confirmNo(Booking $booking)
    {
        if ((int) $booking->user_id !== (int) auth()->id()) {
            abort(403);
        }

        $booking->update([
            'status' => 'rejected',
        ]);

        Message::create([
            'booking_id' => $booking->id,
            'sender_id' => auth()->id(),
            'sender_role' => 'user',
            'message' => 'User rejected booking (NO)',
        ]);

        return redirect()->back()->with('info', 'Booking rejected.');
    }

}
