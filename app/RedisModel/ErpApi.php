<?php

namespace App\RedisModel;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ErpApi
{
    private static $key = 'ErpApi';

    /**
     * 刷新缓存
     * @return bool
     */
    public static function refresh()
    {
        try {
            Redis::del(self::$key);
            $data = [];
            $lists = DB::table('api')
                ->where('status', '=', 1)
                ->get(['id', 'api'])
                ->toArray();
            foreach ($lists as $item) {
                array_push($data, '/' . $item->api, $item->id);
            }
            return Redis::hmset(self::$key, ...$data);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 获取缓存
     * @param string $api 接口地址
     * @return bool
     */
    public static function get($api)
    {
        try {
            if (!Redis::exists(self::$key)) self::refresh();
            return Redis::hget(self::$key, $api);
        } catch (\Exception $e) {
            return false;
        }
    }
}
