<?php
declare (strict_types=1);

namespace App\RedisModel\System;

use Hyperf\DbConnection\Db;
use Hyperf\Extra\Common\RedisModel;

class ResourceRedis extends RedisModel
{
    protected string $key = 'system:resource';

    /**
     * Clear Cache
     */
    public function clear(): void
    {
        $this->redis->del($this->getKey());
    }

    /**
     * Get Cache
     * @return array
     */
    public function get(): array
    {
        if (!$this->redis->exists($this->getKey())) {
            $this->update();
        }
        $raws = $this->redis->get($this->getKey());
        return !empty($raws) ? json_decode($raws, true) : [];
    }

    /**
     * Refresh Cache
     */
    private function update(): void
    {
        $query = Db::table('resource')
            ->where('status', '=', 1)
            ->orderBy('sort')
            ->get(['key', 'parent', 'name', 'nav', 'router', 'policy', 'icon']);

        if ($query->isEmpty()) {
            return;
        }

        $this->redis->set($this->getKey(), json_encode($query->toArray()));
    }
}