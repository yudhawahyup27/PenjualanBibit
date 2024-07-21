<?php

namespace App\Services;

use GuzzleHttp\Client;

class RajaOngkirService
{
    protected $client;
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('RAJAONGKIR_API_KEY');
        $this->baseUrl = 'https://api.rajaongkir.com/starter';
    }

    public function getProvinces()
    {
        $response = $this->client->get("{$this->baseUrl}/province", [
            'headers' => [
                'key' => $this->apiKey,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getCities($provinceId)
    {
        $response = $this->client->get("{$this->baseUrl}/city", [
            'headers' => [
                'key' => $this->apiKey,
            ],
            'query' => [
                'province' => $provinceId,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getCost($origin, $destination, $weight, $courier)
    {
        $response = $this->client->post("{$this->baseUrl}/cost", [
            'headers' => [
                'key' => $this->apiKey,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'origin' => $origin,
                'destination' => $destination,
                'weight' => $weight,
                'courier' => $courier,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
