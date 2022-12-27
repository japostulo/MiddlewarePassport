<?php

namespace Japostulo\MiddlewarePassport\Services;

use Japostulo\MiddlewarePassport\ValueObject\Token;
use Japostulo\MiddlewarePassport\Repositories\UserCacheRepository;
use Japostulo\MiddlewarePassport\Repositories\SingleSignOnRepository;


class UserCacheService
{
    public function __construct(
        private UserCacheRepository $repository,
        private SingleSignOnRepository $singleSignOnRepository,
        private Token $token
    ) {
    }

    public function findByToken(string $token)
    {
        $this->singleSignOnRepository->isAuthenticated($token);

        if ($this->repository->exists($token)) return $this->repository->find($token);

        $user = $this->singleSignOnRepository->introspect($token);

        $this->repository->create($token, json_encode($user), $this->token->getExp($token));

        return $user;
    }
}
