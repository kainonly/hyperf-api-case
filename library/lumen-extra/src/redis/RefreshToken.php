<?php

namespace lumen\extra\redis;

use Illuminate\Support\Facades\Hash;

final class RefreshToken extends RedisModel
{
    protected $key = 'RefreshToken:';

    /**
     * Factory Refresh Token
     * @param string $uuid Token ID
     * @param string $ack Ack Code
     * @return mixed
     */
    public function factory($uuid, $ack, $secret)
    {
        $code = Hash::make($ack);
        return $this->redis->set($this->key . $uuid, $code, $secret);
    }

    /**
     * Verify Refresh Token
     * @param string $uuid Token ID
     * @param string $ack Ack Code
     * @return bool
     */
    public function verify($uuid, $ack)
    {
        if (!$this->redis->exists($this->key . $uuid)) {
            return false;
        }
        return Hash::check($ack, $this->redis->get($this->key . $uuid));
    }
}
