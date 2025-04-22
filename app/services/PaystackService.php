<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class PaystackService
{
    protected $client;
    protected $secretKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->secretKey = env('PAYSTACK_SECRET_KEY');
    }

    // Initialize payment
    public function initializePayment($amount, $email)
    {
        $response = $this->client->post('https://api.paystack.co/transaction/initialize', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'email' => $email,
                'amount' => $amount,
                'callback_url' => route('payment.callback'),
            ],
        ]);

        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }

    // Verify payment
    public function verifyPayment($reference)
    {
        $response = $this->client->get('https://api.paystack.co/transaction/verify/' . $reference, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->secretKey,
            ],
        ]);

        $responseBody = json_decode($response->getBody(), true);
        return $responseBody;
    }
}
