<?php

namespace Japostulo\MiddlewarePassport\Client;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class GuzzleHttpClient extends Client
{
    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function request(string $method, $uri = '', array $options = []): ResponseInterface
    {
        try {
            return parent::request($method, $uri, $options);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
