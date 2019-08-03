<?php

namespace App\Redis;

class ErpRouter
{
    private static $key = 'ErpRouter';

    public static function refresh()
    {
        return true;
    }

    public static function get()
    {
        return [];
    }
}
