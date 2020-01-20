<?php
declare (strict_types=1);

namespace App\RedisModel\System;

use Hyperf\DbConnection\Db;
use Hyperf\Extra\Common\RedisModel;

class RoleRedis extends RedisModel
{
    protected string $key = 'system:role';

    /**
     * Clear Cache
     */
    public function clear(): void
    {
        $this->redis->del($this->key);
    }

    /**
     * Get Role
     * @param array $keys
     * @param string $type
     * @return array
     */
    public function get(array $keys, string $type): array
    {
        if (!$this->redis->exists($this->key)) {
            $this->update();
        }
        $raws = $this->redis->hMGet($this->key, $keys);
        $lists = [];
        foreach ($raws as $value) {
            $data = json_decode($value, true, 512, JSON_THROW_ON_ERROR);
            array_push($lists, ...explode(',', $data[$type]));
        }
        return $lists;
    }

    /**
     * Refresh Cache
     */
    private function update(): void
    {
        $query = Db::table('role')
            ->where('status', '=', 1)
            ->get(['key', 'acl', 'resource']);

        if ($query->isEmpty()) {
            return;
        }

        $lists = [];
        foreach ($query->toArray() as $value) {
            $lists[$value->key] = json_encode([
                'acl' => $value->acl,
                'resource' => $value->resource
            ], JSON_THROW_ON_ERROR, 512);
        }

        $this->redis->hMSet($this->key, $lists);
    }
}