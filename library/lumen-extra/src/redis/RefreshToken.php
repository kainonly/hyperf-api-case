<?php

namespace lumen\extra\Redis;

use Illuminate\Support\Facades\Hash;
use lumen\extra\common\RedisModel;

final class RefreshToken extends RedisModel
{
    protected $key = 'RefreshToken:';

    /**
     * Factory Refresh Token
     * @param string $jti Token ID
     * @param string $ack Ack Code
     * @param int $expires Expires
     * @return mixed
     */
    public function factory(string $jti,
                            string $ack,
                            int $expires)
    {
        return $this->redis->setex(
            $this->key . $jti,
            $expires,
            Hash::make($ack)
        );
    }

    /**
     * Verify Refresh Token
     * @param string $jti Token ID
     * @param string $ack Ack Code
     * @return bool
     */
    public function verify(string $jti,
                           string $ack)
    {
        if (!$this->redis->exists($this->key . $jti)) {
            return false;
        }
        return Hash::check(
            $ack,
            $this->redis->get($this->key . $jti)
        );
    }
}
