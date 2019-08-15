<?php

namespace App\Redis;

use lumen\extra\common\RedisModel;

class SystemStaff extends RedisModel
{
    protected $key = 'system:staff';
}
