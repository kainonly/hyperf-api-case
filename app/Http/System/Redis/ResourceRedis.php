<?php

namespace App\Http\System\Redis;

use Illuminate\Support\Facades\DB;
use lumen\extra\common\RedisModel;

class ResourceRedis extends RedisModel
{
    protected $key = 'system:resource';
    private $rows = [];

    /**
     * Clear Redis
     * @return bool
     */
    public function clear()
    {
        return (bool)$this->redis->del([$this->key]);
    }

    /**
     * Get Resource
     * @return array
     */
    public function get()
    {
        if (!$this->redis->exists($this->key)) {
            $this->update();
        } else {
            $this->rows = json_decode($this->redis->get($this->key), true);
        }

        return $this->rows;
    }

    /**
     * Update Redis
     */
    private function update()
    {
        $lists = DB::table('resource')
            ->where('status', '=', 1)
            ->orderBy('sort')
            ->get(['id', 'key', 'parent', 'name', 'nav', 'router', 'policy', 'icon']);

        if (empty($lists)) {
            return;
        }

        $this->redis->set($this->key, json_encode($lists));
        $this->rows = $lists;
    }
}
