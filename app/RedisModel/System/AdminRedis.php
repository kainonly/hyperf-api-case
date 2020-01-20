<?php
declare (strict_types=1);

namespace App\RedisModel\System;

use Hyperf\DbConnection\Db;
use Hyperf\Extra\Common\RedisModel;

class AdminRedis extends RedisModel
{
    protected string $key = 'system:admin';

    /**
     * Clear Cache
     */
    public function clear(): void
    {
        $this->redis->del($this->key);
    }

    /**
     * Get Cache
     * @param string $username
     * @return array
     */
    public function get(string $username): array
    {
        if (!$this->redis->exists($this->key)) {
            $this->update();
        }

        $raws = $this->redis->hGet($this->key, $username);
        return !empty($raws) ?
            json_decode($raws, true, 512, JSON_THROW_ON_ERROR) : [];
    }

    /**
     * Refresh Cache
     */
    private function update(): void
    {
        $query = Db::table('admin')
            ->where('status', '=', 1)
            ->get(['id', 'role', 'username', 'password']);

        if ($query->isEmpty()) {
            return;
        }

        $lists = [];
        foreach ($query->toArray() as $value) {
            $lists[$value->username] = json_encode($value, JSON_THROW_ON_ERROR, 512);
        }
        $this->redis->hMSet($this->key, $lists);
    }
}