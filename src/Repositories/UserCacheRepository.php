<?php

namespace Japostulo\MiddlewarePassport\Repositories;

use Illuminate\Support\Facades\Cache;

class UserCacheRepository
{
    public function find($key)
    {
        $user = Cache::get($key);
        return json_decode($user);
    }

    /**
     * @param $key Chave de identificação do cache
     * @param $value Valor a ser armazenado no Cache
     * @param @expiresIn data de expiração do Cache
     */
    public function create(string $key, string $value, $expiresIn)
    {
        return Cache::put($key, $value, $expiresIn);
    }

    public function exists(string $key): bool
    {
        return Cache::has($key);
    }

    public function delete($key): bool
    {
        return Cache::forget($key);
    }
}
