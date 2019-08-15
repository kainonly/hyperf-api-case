<?php

namespace App\Redis;

use lumen\extra\common\RedisModel;

class SystemRole extends RedisModel
{
    protected $key = 'system:role';

}
