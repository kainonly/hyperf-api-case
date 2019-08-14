<?php

namespace lumen\extra\common;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Redis\RedisManager;
use Predis\Transaction\MultiExec;

abstract class RedisModel
{
    /**
     * Model key
     * @var string $key
     */
    protected $key;

    /**
     * Redis Manager
     * @var RedisManager $redis
     */
    protected $redis;

    /**
     * RedisModel constructor.
     * @param RedisManager|Pipeline|MultiExec $redis
     */
    public function __construct($redis = null)
    {
        $this->redis = $redis ? $redis : app()->make('redis');
    }
}
