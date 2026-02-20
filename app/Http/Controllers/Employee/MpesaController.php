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
        $validated = $request->validate([
            'phone' => ['required', 'regex:/^(?:254|0)?7\d{8}$/'],
        ]);

        $phone = $this->normalizePhone($validated['phone']);

        // test values
        $amount = 1;
        $reference = 'TestRef';
        $description = 'Employee Dashboard STK Test';

        try {
            $response = $mpesa->stkPush($amount, $phone, $reference, $description);
        } catch (\Throwable $e) {
            return back()->with('error', 'STK push failed: ' . $e->getMessage());
        }

        return back()->with('success', 'STK Push initiated! Check your phone.')
                     ->with('mpesa_response', $response);
    }

    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D+/', '', $phone);

        if (str_starts_with($phone, '07')) {
            return '254' . substr($phone, 1);
        }

        if (str_starts_with($phone, '7')) {
            return '254' . $phone;
        }

        return $phone;
    }
}
