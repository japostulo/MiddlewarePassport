<?php

namespace Japostulo\MiddlewarePassport\Middlewares;

use Exception;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Japostulo\MiddlewarePassport\Exceptions\SingleSignOnException;
use Japostulo\MiddlewarePassport\Repositories\SingleSignOnRepository;

class SingleSignOnClientAuthenticate extends Middleware
{
    public function __construct(private SingleSignOnRepository $repository)
    {
    }

    public function handle($request, $next, ...$guards)
    {
        try {
            if (!$request->header('authorization')) throw new SingleSignOnException(SingleSignOnException::Token_Not_Found);

            $this->repository->isAuthenticated($request->header('authorization'));

            return $next($request);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }
}
