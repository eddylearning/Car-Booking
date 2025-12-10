<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MpesaService
{
    public function generateAccessToken()
    {
        $consumerKey = env('MPESA_CONSUMER_KEY');
        $consumerSecret = env('MPESA_CONSUMER_SECRET');

        $response = Http::withBasicAuth($consumerKey, $consumerSecret)
            ->get('https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials');

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

        $response = Http::withToken($accessToken)
            ->post('https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest', $payload);

        return $response->json();
    }
}
