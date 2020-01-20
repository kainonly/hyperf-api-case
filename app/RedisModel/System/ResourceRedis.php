<?php
declare (strict_types=1);

namespace App\RedisModel\System;

use Hyperf\DbConnection\Db;
use Hyperf\Extra\Common\RedisModel;

class ResourceRedis extends RedisModel
{
    protected string $key = 'system:resource';
    private array $data = [];

    /**
     * Clear Cache
     */
    public function clear(): void
    {
        $this->redis->del($this->key);
    }

    /**
     * Get Cache
     * @return array
     */
    public function get(): array
    {
        if (!$this->redis->exists($this->key)) {
            $this->update();
        } else {
            $raws = $this->redis->get($this->key);
            $this->data = json_decode($raws, true);
        }
        return $this->data;
    }

    /**
     * Refresh Cache
     */
    private function update(): void
    {
        $queryLists = Db::table('resource')
            ->where('status', '=', 1)
            ->orderBy('sort')
            ->get(['key', 'parent', 'name', 'nav', 'router', 'policy', 'icon']);

        if ($queryLists->isEmpty()) {
            return;
        }

        $data = (array)$queryLists->toArray();
        $this->redis->set($this->key, json_encode($data));
        $this->data = $data;
    }
}