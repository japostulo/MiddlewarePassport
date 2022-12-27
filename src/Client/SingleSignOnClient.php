<?php

namespace Japostulo\MiddlewarePassport\Client;

use GuzzleHttp\Client;
use Japostulo\MiddlewarePassport\Client\ClientContract;

class SingleSignOnClient implements ClientContract
{
    public function __construct($client = Client::class)
    {
        $this->client = new $client([
            'base_uri' => env('SSO_URL'),
            'headers' => [
                'Accept' => 'application/json',
            ],
            'timeout' => 8,
        ]);
    }

    public function getHttpClient()
    {
        return $this->client;
    }
}
