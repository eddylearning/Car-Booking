<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class MpesaService
{
    public function generateAccessToken()
    {
        $consumerKey = env('MPESA_CONSUMER_KEY');
        $consumerSecret = env('MPESA_CONSUMER_SECRET');

        $response = Http::retry(2, 1000)
            ->timeout(30)
            ->withBasicAuth($consumerKey, $consumerSecret)
            ->get('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');

        if (!$response->ok() || empty($response['access_token'])) {
            Log::error('MPESA token request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new \RuntimeException('Unable to get MPESA access token.');
        }

        return $response['access_token'];
    }

    public function stkPush($amount, $phone, $reference, $description)
    {
        $accessToken = $this->generateAccessToken();

        $shortCode = env('MPESA_SHORTCODE');
        $passKey = env('MPESA_PASSKEY');
        $callbackUrl = env('MPESA_CALLBACK_URL');

        $timestamp = date('YmdHis');
        $password = base64_encode($shortCode . $passKey . $timestamp);

        $payload = [
            "BusinessShortCode" => $shortCode,
            "Password" => $password,
            "Timestamp" => $timestamp,
            "TransactionType" => "CustomerPayBillOnline",
            "Amount" => $amount,
            "PartyA" => $phone,
            "PartyB" => $shortCode,
            "PhoneNumber" => $phone,
            "CallBackURL" => $callbackUrl,
            "AccountReference" => $reference,
            "TransactionDesc" => $description
        ];

        $response = Http::retry(2, 1000)
            ->timeout(30)
            ->withToken($accessToken)
            ->post('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest', $payload);

        if (!$response->ok()) {
            Log::error('MPESA STK request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new \RuntimeException('MPESA STK push request failed.');
        }

        return $response->json() ?? [];
    }
}
