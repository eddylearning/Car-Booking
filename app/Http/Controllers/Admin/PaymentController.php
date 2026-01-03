<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentController extends Controller
{
    /**
     * List all payments
     */
    public function index()
    {
        $payments = Payment::with(['booking.user', 'booking.car'])
            ->latest()
            ->paginate(10);

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Show single payment details
     */
    public function show(Payment $payment)
    {
        $payment->load(['booking.user', 'booking.car']);

        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Manually mark payment as completed (admin override)
     */
    public function markCompleted(Payment $payment)
    {
        if ($payment->status === 'completed') {
            return back()->with('info', 'Payment already completed.');
        }

        $payment->update([
            'status' => 'completed'
        ]);

        // Update booking status too
        if ($payment->booking) {
            $payment->booking->update([
                'status' => 'paid'
            ]);
        }

        return back()->with('success', 'Payment marked as completed.');
    }
}
