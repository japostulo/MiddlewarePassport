<?php

namespace Japostulo\MiddlewarePassport\Repositories;

use Exception;
use Japostulo\MiddlewarePassport\Client\SingleSignOnClient;
use Japostulo\MiddlewarePassport\Exceptions\SingleSignOnException;

class SingleSignOnRepository
{

    public function __construct(private SingleSignOnClient $http)
    {
        $this->client = $http->getHttpClient();
    }

    public function introspect($token)
    {
        try {
            $response = (object) $this->client->get('/api/introspect', [
                'headers' => [
                    'authorization' => $token
                ],
            ]);
            return (object) json_decode($response->getBody()->getContents());
        } catch (Exception  $e) {
            $exception = match ($e->getCode()) {
                401 => SingleSignOnException::Unauthenticated,
                default => SingleSignOnException::Server_Error['message'] + "\n $e->getMessage()"
            };
            throw new SingleSignOnException($exception);
        }
    }

    public function isAuthenticated($token)
    {
        try {
            $response = (object) $this->client->get('/api/authenticated', [
                'headers' => [
                    'authorization' => $token
                ],
            ]);
            return (object) json_decode($response->getBody()->getContents());
        } catch (Exception  $e) {
            $exception = match ($e->getCode()) {
                401 => SingleSignOnException::Unauthenticated,
                default => SingleSignOnException::Server_Error
            };
            throw new SingleSignOnException($exception);
        }
    }


    public function clientAuthenticate(string $clientId, string $clientSecret)
    {
        try {
            $response = (object) $this->client->post('/oauth/token', [
                'json' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret
                ],
            ]);

            return (object) json_decode($response->getBody()->getContents());
        } catch (Exception  $e) {
            throw new SingleSignOnException(SingleSignOnException::Server_Error['message'] + "\n $e->getMessage()");
        }
    }
}
