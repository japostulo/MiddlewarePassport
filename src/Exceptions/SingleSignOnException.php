<?php

namespace Japostulo\MiddlewarePassport\Exceptions;

use \Exception;

class SingleSignOnException extends Exception
{

    const Unauthenticated = [
        'message' => 'Usuário não autenticado',
        'code' => 401
    ];

    const Server_Error = [
        'message' => 'Erro no servidor, entre em contato com o administrador!',
        'code' => 500
    ];


    const Token_Not_Found = [
        'message' => 'Token não foi encontrado',
        'code' => 400
    ];

    public function __construct($exception)
    {
        parent::__construct($exception['message'], $exception['code']);
    }
}
