<?php

namespace Japostulo\MiddlewarePassport\ValueObject;

use DateTime;
use Illuminate\Support\Carbon;

class Token
{
    public $decodedToken;

    public function __construct(protected $token = null)
    {
    }

    public function decode($token = null)
    {
        $token = preg_replace("/Bearer /", '', $token ?? $this->token);
        $tokenParts = explode(".", $token);
        $tokenPayload = base64_decode($tokenParts[1]);
        $token = json_decode($tokenPayload);

        $this->decodedToken = (object) [
            'aud' => $token->aud,
            'jti' => $token->jti,
            'iat' => new Carbon($token->iat),
            'nbf' => new Carbon($token->nbf),
            'exp' => new Carbon($token->exp),
            'sub' => $token->sub,
            'scopes' => $token->scopes,
        ];

        return $this->decodedToken;
    }

    public function getExp($token = null): DateTime
    {
        $token = $this->decodedToken ?? $this->decode($token);
        return $token->exp;
    }
}
