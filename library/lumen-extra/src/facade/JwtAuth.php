<?php

namespace lumen\extra\facade;

use Illuminate\Support\Facades\Facade;

/**
 * Class JwtAuth
 * @method static array setToken(string $scene, array $symbol = [])
 * @method tokenVerify(string $scene, string $token)
 * @package lumen\extra\jwt
 */
class JwtAuth extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'jwt';
    }
}
