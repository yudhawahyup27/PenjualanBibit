<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TripayService
{
    protected $apiKey;
    protected $privateKey;
    protected $merchantCode;

    public function __construct()
    {
        $this->apiKey = env('TRIPAY_API_KEY');
        $this->privateKey = env('TRIPAY_PRIVATE_KEY');
        $this->merchantCode = env('TRIPAY_MERCHANT_CODE');
    }

    // public function getPaymentMethods()
    // {
    //     $response = Http::withHeaders([
    //         'Authorization' => 'Bearer ' . $this->apiKey
    //     ])->get('https://tripay.co.id/api-sandbox/merchant/payment-channel');

    //     return $response->json();
    // }

    public function createTransaction($data)
    {
        $payload = [
            'method'         => $data['method'],
            'merchant_ref'   => $data['merchant_ref'],
            'amount'         => $data['amount'],
            'customer_name'  => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'],
            'order_items'    => $data['order_items'],
            'callback_url'   => $data['callback_url'],
            'return_url'     => $data['return_url'],
            'expired_time'   => $data['expired_time'],
            'signature'      => $this->createSignature($this->merchantCode, $data['method'], $data['merchant_ref']),
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey
        ])->post('https://tripay.co.id/api-sandbox/transaction/create', $payload);

        return $response->json();
    }

    public function createSignature($merchantCode, $channel, $merchantRef)
    {
        // Build the message to be signed
        $message = $merchantCode . $channel . $merchantRef;

        // Generate the signature using HMAC-SHA256
        return hash_hmac('sha256', $message, $this->privateKey);
    }
}

