<?php

namespace App\Http\System\Redis;

use Illuminate\Support\Facades\DB;
use lumen\extra\common\RedisModel;

class Resource extends RedisModel
{
    protected $key = 'system:resource';

    /**
     * @return bool
     */
    public function refresh()
    {
        $this->redis->del([$this->key]);
        $lists = DB::table('resource')
            ->where('status', '=', 1)
            ->orderBy('sort')
            ->get(['id', 'key', 'parent', 'name', 'nav', 'router', 'policy', 'icon']);

        return (boolean)$this->redis->set($this->key, json_encode($lists));
    }

    /**
     * @return mixed
     */
    public function get()
    {
        if (!$this->redis->exists($this->key)) {
            $this->refresh();
        }

        return json_decode($this->redis->get($this->key), true);
    }
}
