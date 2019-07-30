<?php

namespace App\RedisModel;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use lumen\extra\Ext;

class ErpRouter
{
    private static $key = 'ErpRouter';

    /**
     * 刷新缓存
     * @return bool
     */
    public static function refresh()
    {
        try {
            $lists = DB::table('router')
                ->where('status', '=', 1)
                ->orderBy('sort')
                ->get(['id', 'parent', 'name', 'nav', 'icon', 'routerlink']);
            return Redis::set(self::$key, Ext::pack($lists->toArray()));
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 获取缓存
     * @return array
     */
    public static function get()
    {
        try {
            if (!Redis::exists(self::$key)) self::refresh();
            return Ext::unpack(Redis::get(self::$key));
        } catch (\Exception $e) {
            return [];
        }
    }
}
