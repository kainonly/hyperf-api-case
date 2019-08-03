<?php

namespace App\Redis;

class ErpRoleApi
{
    private static $key = 'ErpRoleApi';

    public static function refresh()
    {
        return true;
    }

    public static function get($id)
    {
        return [];
    }
}
