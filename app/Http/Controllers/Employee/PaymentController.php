<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use App\Services\MpesaService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $mpesa;

    public function __construct(MpesaService $mpesa)
    {
        $this->mpesa = $mpesa;
    }

    // Show pending payments
    public function index()
    {
        $payments = Payment::with('booking')->latest()->paginate(10);
        return view('employee.payments.index', compact('payments'));
    }

    // Initiate payment via STK Push
    public function pay(Booking $booking)
    {
        if ($booking->payment?->status === 'completed') {
            return back()->with('error', 'Payment already completed.');
        }

        $amount = $booking->total_price; // booking model should have this
        $phone = $booking->user->phone; //from the yes reply

        $response = $this->mpesa->stkPush($amount, $phone, "Booking-{$booking->id}", "Car Booking Payment");

        // Save payment record
        $payment = Payment::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'phone' => $phone,
                'amount' => $amount,
                'status' => 'pending',
                'response' => $response
            ]
        );

        return back()->with('success', 'STK Push sent. Awaiting payment confirmation.');
    }
}
