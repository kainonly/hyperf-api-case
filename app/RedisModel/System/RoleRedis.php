<?php
declare (strict_types=1);

namespace App\RedisModel\System;

use Hyperf\DbConnection\Db;
use Hyperf\Extra\Redis\Library\RoleLibrary;
use Hyperf\Extra\Redis\RedisModel;

class RoleRedis extends RedisModel implements RoleLibrary
{
    protected string $key = 'system:role';

    /**
     * Clear Cache
     */
    public function clear(): void
    {
        $this->redis->del($this->getKey());
    }

    /**
     * Get Role
     * @param array $keys
     * @param string $type
     * @return array
     */
    public function get(array $keys, string $type): array
    {
        if (!$this->redis->exists($this->getKey())) {
            $this->update();
        }
        $raws = $this->redis->hMGet($this->getKey(), $keys);
        if (empty($raws)) {
            return [];
        }
        $lists = [];
        foreach ($raws as $value) {
            $data = json_decode($value, true);
            array_push($lists, ...$data[$type]);
        }
        return $lists;
    }

    /**
     * Refresh Cache
     */
    private function update(): void
    {
        $query = Db::table('role_mix')
            ->where('status', '=', 1)
            ->get(['key', 'acl', 'resource', 'permission']);

        if ($query->isEmpty()) {
            return;
        }
        $lists = [];
        foreach ($query->toArray() as $value) {
            $lists[$value->key] = json_encode([
                'acl' => !empty($value->acl) ? explode(',', $value->acl) : [],
                'resource' => !empty($value->resource) ? explode(',', $value->resource) : [],
                'permission' => !empty($value->permission) ? explode(',', $value->permission) : []
            ]);
        }

        $this->redis->hMSet($this->getKey(), $lists);
    }
}