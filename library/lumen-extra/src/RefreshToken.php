<?php


namespace lumen\extra;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class RefreshToken
{
    private static $key = 'RefreshToken:';

    /**
     * Factory Refresh Token
     * @param string $uuid Token ID
     * @param string $ack Ack Code
     * @return bool
     */
    public static function factory($uuid, $ack)
    {
        try {
            $code = Hash::make($ack);
            return Redis::set(self::$key . $uuid, $code, Config::get('app.key'));
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Verify Refresh Token
     * @param string $uuid Token ID
     * @param string $ack Ack Code
     * @return bool
     */
    public static function verify($uuid, $ack)
    {
        try {
            if (!Redis::exists(self::$key . $uuid)) return false;
            return Hash::check($ack, Redis::get(self::$key . $uuid));
        } catch (\Exception $e) {
            return false;
        }
    }
}
