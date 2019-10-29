<?php

namespace App\Http\System\Redis;

use Illuminate\Support\Facades\DB;
use Lumen\Support\Common\RedisModel;

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
        return (bool)$this->redis->del($this->key);
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
        $queryLists = Db::table('resource')
            ->where('status', '=', 1)
            ->orderBy('sort')
            ->get(['key', 'parent', 'name', 'nav', 'router', 'policy', 'icon']);

        if ($queryLists->isEmpty()) {
            return;
        }

        $this->redis->set($this->key, $queryLists->toJson());
        $this->rows = $queryLists->toArray();
    }
}
