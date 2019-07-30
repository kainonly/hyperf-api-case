<?php

namespace App\RedisModel;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use lumen\extra\common\Ext;

class ErpRoleRouter
{
    private static $key = 'ErpRoleRouter';

    /**
     * 刷新缓存
     * @return bool
     */
    public static function refresh()
    {
        try {
            Redis::del(self::$key);
            $data = [];
            $lists = DB::table('role')
                ->where('status', '=', 1)
                ->get(['id', 'router'])
                ->toArray();
            foreach ($lists as $item) {
                array_push($data, $item->id, $item->router);
            }
            return Redis::hmset(self::$key, ...$data);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 获取授权路由
     * @param int $id 权限组主键
     * @return array
     */
    public static function get($id)
    {
        try {
            if (!Redis::exists(self::$key)) self::refresh();
            return Ext::unpack(Redis::hget(self::$key, $id));
        } catch (\Exception $e) {
            return [];
        }
    }
}
