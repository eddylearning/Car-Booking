<?php

namespace App\Http\Controllers\Traits;

use App\Models\Message;
use App\Models\Booking;

trait HandlesBookingMessages
{
    /**
     * Get all messages for a booking (conversation thread)
     */
    protected function getConversation(int $bookingId)
    {
        return Message::where('booking_id', $bookingId)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Send a normal message
     */
    protected function sendMessage(
        int $bookingId,
        ?int $senderId,
        string $senderRole,
        string $message
    ): Message {
        return Message::create([
            'booking_id'  => $bookingId,
            'sender_id'   => $senderId,
            'sender_role' => $senderRole,
            'message'     => $message,
        ]);
    }

    /**
     * Create a system-generated message
     */
    protected function createSystemMessage(
        int $bookingId,
        string $message
    ): Message {
        return Message::create([
            'booking_id'  => $bookingId,
            'sender_id'   => null,
            'sender_role' => 'system',
            'message'     => $message,
        ]);
    }
}
