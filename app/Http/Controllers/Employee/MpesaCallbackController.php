<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class MpesaCallbackController extends Controller
{
    public function handle(Request $request)
    {
        $data = $request->all();

        // Extract details from Daraja response
        $resultCode = $data['Body']['stkCallback']['ResultCode'] ?? null;
        $checkoutRequestID = $data['Body']['stkCallback']['CheckoutRequestID'] ?? null;
        $amount = $data['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'] ?? null;
        $mpesaReceipt = $data['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'] ?? null;
        $phone = $data['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'] ?? null;

        // Find payment by CheckoutRequestID
        $payment = Payment::whereJsonContains('response', ['CheckoutRequestID' => $checkoutRequestID])->first();

        if ($payment) {
            $payment->update([
                'status' => $resultCode === 0 ? 'completed' : 'failed',
                'mpesa_receipt' => $mpesaReceipt,
                'response' => $data
            ]);
        }

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted']);
    }
}
