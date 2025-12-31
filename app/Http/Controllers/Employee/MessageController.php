<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesBookingMessages;
use App\Models\Booking;
use App\Models\Message;
use App\Services\MpesaService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    use HandlesBookingMessages;

    /**
     * Inbox – all bookings with messages
     */
    public function index()
    {
        $bookings = Booking::with(['messages', 'user', 'car'])
            ->latest()
            ->get();

        return view('employee.messages.index', compact('bookings'));
    }

    /**
     * Show conversation for a booking
     */
    public function show($bookingId)
    {
        $booking = Booking::with(['user', 'car'])
            ->findOrFail($bookingId);

        $messages = $this->getConversation($bookingId);

        return view('employee.messages.show', compact('booking', 'messages'));
    }

    /**
     * Send a message from employee
     */
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'message'    => 'required|string',
        ]);

        $booking = Booking::findOrFail($request->booking_id);
        $messageText = trim($request->message);

        // Save employee message
        $this->sendMessage(
            $booking->id,
            auth()->id(),
            'employee',
            $messageText
        );

        /**
         * 🔍 Detect YES / NO from USER
         * This logic runs when employee is replying AFTER user message
         */

        $upper = strtoupper($messageText);

        // USER SAID NO
        if ($upper === 'NO') {
            $booking->update(['status' => 'cancelled']);

            $this->createSystemMessage(
                $booking->id,
                'Booking cancelled by user.'
            );

            return back()->with('info', 'Booking cancelled.');
        }

        return back()->with('success', 'Message sent.');
    }

    /**
     * Confirm availability & ask user to proceed
     */
    public function confirmAvailability($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        $booking->update(['status' => 'approved']);

        $this->createSystemMessage(
            $booking->id,
            'Car is available. Reply YES + phone number to proceed with payment, or NO to cancel.'
        );

        return back()->with('success', 'Availability confirmed.');
    }

    /**
     * Send MPESA STK Push
     */
    public function sendStkPush(Request $request, MpesaService $mpesa)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'phone'      => 'required|string',
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        // Trigger STK Push
        $mpesa->stkPush(
            $booking->id,
            $request->phone,
            'Booking #' . $booking->id,
            'Car booking payment'
        );

        $this->createSystemMessage(
            $booking->id,
            'STK Push sent to ' . $request->phone
        );

        return back()->with('success', 'STK push sent.');
    }
}



// public function store(Request $request)
// {
//     $request->validate([
//         'booking_id' => 'required|exists:bookings,id',
//         'message'    => 'required|string',
//     ]);

//     $booking = Booking::findOrFail($request->booking_id);
//     $messageText = trim($request->message);

//     // Save employee message
//     $this->sendMessage(
//         $booking->id,
//         auth()->id(),
//         'employee',
//         $messageText
//     );

//     $upper = strtoupper($messageText);

//     // USER SAID NO
//     if ($upper === 'NO') {
//         $booking->update(['status' => 'cancelled']);

//         $this->createSystemMessage(
//             $booking->id,
//             'Booking cancelled by user.'
//         );

//         return back()->with('info', 'Booking cancelled.');
//     }

//     // USER SAID YES + phone
//     if (str_starts_with($upper, 'YES')) {
//         // Extract phone number using regex
//         preg_match('/\d{10,12}/', $messageText, $matches);
//         $phone = $matches[0] ?? null;

//         if (!$phone) {
//             return back()->with('error', 'Please provide a valid phone number after YES.');
//         }

//         $booking->update([
//             'status'       => 'confirmed',
//             'phone_number' => $phone,
//         ]);

//         $this->createSystemMessage(
//             $booking->id,
//             "Booking confirmed by user. Phone for STK push: $phone"
//         );

//         return back()->with('success', 'Booking confirmed. You can now send STK push.');
//     }

//     return back()->with('success', 'Message sent.');
// }
