<?php

namespace Japostulo\MiddlewarePassport\Client;

use Japostulo\MiddlewarePassport\Client\GuzzleHttpClient;

class Client
{

    protected $config = [];

    public function setConfig(string $name, $value)
    {
        $this->config[$name] = $value;
    }

    public function getClient()
    {
        return new GuzzleHttpClient($this->config);
    }
}
