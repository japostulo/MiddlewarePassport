<?php

namespace Japostulo\MiddlewarePassport\Middlewares;

use Exception;
use Japostulo\MiddlewarePassportModels\User;
use Illuminate\Support\Facades\Auth;
use Japostulo\MiddlewarePassport\Services\UserCacheService;
use Japostulo\MiddlewarePassport\Exceptions\SingleSignOnException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class SingleSignOnPasswordAuthenticate extends Middleware
{
    public function __construct(private UserCacheService $service)
    {
    }

    public function handle($request, $next, ...$guards)
    {
        try {
            if (!$request->header('authorization')) throw new SingleSignOnException(SingleSignOnException::Token_Not_Found);

            $user = (array) $this->service->findByToken($request->header('authorization'));

            $this->setLaravelAuthUser($user, $request);

            return $next($request);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function setLaravelAuthUser($user, $request): void
    {
        $request->setUserResolver(function () use ($user) {
            return new User($user);
        });

        Auth::setUser($request->user());
    }
}
