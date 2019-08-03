<?php

namespace App\Redis;

class ErpRoleRouter
{
    private static $key = 'ErpRoleRouter';

    public static function refresh()
    {
        return true;
    }

    public static function get($id)
    {
        return [];
    }
}
