<?php

namespace lumen\extra\jwt;

use Illuminate\Support\Str;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use lumen\extra\redis\RefreshToken;

final class JwtAuthFactory
{
    /**
     * JWT config
     * @var array $config
     */
    private $config;

    /**
     * App secret
     * @var string $secret
     */
    private $secret;

    /**
     * Jwt signer
     * @var Sha256 $signer
     */
    private $signer;

    public function __construct(string $secret, array $config)
    {
        $this->secret = $secret;
        $this->config = $config;
        $this->signer = new Sha256();
    }

    /**
     * Set Token
     * @param string $scene Token scene
     * @param array $symbol Symbol Tag
     * @return array
     */
    public function setToken(string $scene, array $symbol = [])
    {
        $jti = (string)Str::uuid();
        $ack = Str::random();
        $token = (new Builder())
            ->issuedBy($this->config[$scene]['issuer'])
            ->permittedFor($this->config[$scene]['audience'])
            ->identifiedBy($jti, true)
            ->withClaim('ack', $ack)
            ->withClaim('symbol', $symbol)
            ->expiresAt(time() + $this->config['expires'])
            ->getToken($this->signer, new Key($this->secret));

        $result = (new RefreshToken)->factory($jti, $ack, $this->secret);
        return [
            'auto_refresh' => $result,
            'token' => (string)$token
        ];
    }

    /**
     * Token Verify
     * @param string $scene Token scene
     * @param string $token Token
     * @return boolean|string
     */
    public function tokenVerify(string $scene, string $token)
    {
        $token = (new Parser())->parse($token);
        if (!$token->verify($this->signer, $this->secret)) {
            return false;
        }

        if ($token->getClaim('iss') != $this->config[$scene]['issuer'] ||
            $token->getClaim('aud') != $this->config[$scene]['audience']) {
            return false;
        }

        if ($token->isExpired()) {
            $result = (new RefreshToken)->verify(
                $token->getClaim('jti'),
                $token->getClaim('ack')
            );

            if (!$result) {
                return false;
            }

            $newToken = (new Builder())
                ->issuedBy($this->config[$scene]['issuer'])
                ->permittedFor($this->config[$scene]['audience'])
                ->identifiedBy($token->getClaim('jti'), true)
                ->withClaim('ack', $token->getClaim('ack'))
                ->withClaim('symbol', $token->getClaim('symbol'))
                ->expiresAt(time() + $this->config['expires'])
                ->getToken($this->signer, new Key($this->secret));

            $token = $newToken;
            return (string)$token;
        }
        return true;
    }

}
