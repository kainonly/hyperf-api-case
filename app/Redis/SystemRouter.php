<?php

namespace App\Redis;

use lumen\extra\common\RedisModel;

class SystemRouter extends RedisModel
{
    protected $key = 'system:router';

}
