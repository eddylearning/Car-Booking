<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Services\MpesaService;
use Illuminate\Http\Request;

class MpesaController extends Controller
{
    public function showTestPage()
    {
        return view('employee.payments.test');
    }

    public function testStkPush(Request $request, MpesaService $mpesa)
    {
        // test values
        $amount = 1;
        $phone = $request->phone ?? '2547XXXXXXXX';
        $reference = 'TestRef';
        $description = 'Employee Dashboard STK Test';

        $response = $mpesa->stkPush($amount, $phone, $reference, $description);

        return back()->with('success', 'STK Push initiated! Check your phone.')
                     ->with('mpesa_response', $response);
    }
}
