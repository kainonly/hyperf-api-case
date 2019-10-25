<?php

namespace App\RedisModel;

use Hyperf\DbConnection\Db;
use Hyperf\Support\Common\RedisModel;

class Resource extends RedisModel
{
    protected $key = 'app:resource';
    private $rows = [];

    public function clear()
    {
        $this->redis->del($this->key);
    }

    public function get()
    {
        if (!$this->redis->exists($this->key)) {
            $this->update();
        } else {
            $this->rows = json_decode($this->redis->get($this->key), true);
        }

        return $this->rows;
    }

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