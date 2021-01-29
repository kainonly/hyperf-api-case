<?php
declare (strict_types=1);

namespace App\RedisModel\System;

use Hyperf\DbConnection\Db;
use Hyperf\Extra\Redis\RedisModel;

class AdminRedis extends RedisModel
{
    protected string $key = 'system:admin';

    /**
     * Clear Cache
     */
    public function clear(): void
    {
        $this->redis->del($this->getKey());
    }

    /**
     * Get Cache
     * @param string $username
     * @return array
     */
    public function get(string $username): array
    {
        if (!$this->redis->exists($this->getKey())) {
            $this->update();
        }

        $raws = $this->redis->hGet($this->getKey(), $username);
        return !empty($raws) ? json_decode($raws, true) : [];
    }

    /**
     * Refresh Cache
     */
    private function update(): void
    {
        $query = Db::table('admin_mix')
            ->where('status', '=', 1)
            ->get(['id', 'role', 'username', 'password']);

        if ($query->isEmpty()) {
            return;
        }

        $lists = [];
        foreach ($query->toArray() as $value) {
            $lists[$value->username] = json_encode($value);
        }
        $this->redis->hMSet($this->getKey(), $lists);
    }
}