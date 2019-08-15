<?php

namespace App\Redis;

use lumen\extra\common\RedisModel;

class SystemApi extends RedisModel
{
    protected $key = 'system:api';

}
