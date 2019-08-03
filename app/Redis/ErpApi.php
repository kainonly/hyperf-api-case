<?php

namespace App\Redis;

class ErpApi
{
    private static $key = 'ErpApi';

    public static function refresh()
    {
        return true;
    }

    public static function get($api)
    {
        return [];
    }
}
