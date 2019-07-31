<?php

namespace lumen\extra;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Facade;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Token;

final class JwtAuth extends Facade
{
    /**
     * Set Token
     * @param string $label Lable
     * @param string $userId User ID
     * @param string $roleId Role ID
     * @param array $symbol Symbol Tag
     * @return boolean
     */
    public static function setToken($label, $userId, $roleId, $symbol = [])
    {
        $config = Config::get('jwt');
        $secret = Config::get('app.key');
        $jti = Ext::uuid();
        $ack = Ext::random();
        $token = (new Builder())
            ->issuedBy($config[$label]['issuer'])
            ->permittedFor($config[$label]['audience'])
            ->identifiedBy($jti, true)
            ->withClaim('ack', $ack)
            ->withClaim('user', $userId)
            ->withClaim('role', $roleId)
            ->withClaim('symbol', $symbol)
            ->expiresAt(time() + $config['expires'])
            ->getToken($config['signer'], $secret);
        $result = RefreshToken::factory($jti, $ack);
        if (!$result) {
            return false;
        } else {
            Cookie::queue($label, (string)$token);
            return true;
        }
    }

    /**
     * Token Verify
     * @param string $label
     * @return boolean|Token
     */
    public static function tokenVerify($label)
    {
        $config = Config::get('jwt');
        $secret = Config::get('app.key');
        if (!Cookie::get($label)) return false;

        $token = (new Parser())->parse(Cookie::get($label));
        if (!$token->verify($config['signer'], $secret)) return false;

        if ($token->getClaim('iss') != $config[$label]['issuer'] ||
            $token->getClaim('aud') != $config[$label]['audience']) return false;

        if ($token->isExpired()) {
            $result = (new RefreshToken())->verify(
                $token->getClaim('jti'),
                $token->getClaim('ack')
            );
            if (!$result) return false;
            $newToken = (new Builder())
                ->issuedBy($config[$label]['issuer'])
                ->permittedFor($config[$label]['audience'])
                ->identifiedBy($token->getClaim('jti'), true)
                ->withClaim('ack', $token->getClaim('ack'))
                ->withClaim('user', $token->getClaim('user'))
                ->withClaim('role', $token->getClaim('role'))
                ->withClaim('symbol', $token->getClaim('symbol'))
                ->expiresAt(time() + $config['expires'])
                ->getToken($config['signer'], $secret);
            $token = $newToken;
            Cookie::queue($label, (string)$token);
        }
        return $token;
    }

    /**
     * Clear Token
     * @param string $label
     */
    public static function tokenClear($label)
    {
        Cookie::queue(Cookie::forget($label));
    }
}
