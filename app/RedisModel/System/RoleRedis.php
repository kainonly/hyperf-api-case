<?php
declare (strict_types=1);

namespace App\RedisModel\System;

use Hyperf\DbConnection\Db;
use Hyperf\Extra\Common\RedisModel;

class RoleRedis extends RedisModel
{
    protected string $key = 'system:role';
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
     * @param string $key
     * @param string $type
     * @return array
     */
    public function get(string $key, string $type): array
    {
        if (!$this->redis->exists($this->key)) {
            $this->update($key);
        } else {
            $raws = $this->redis->hget($this->key, $key);
            $this->data = !empty($raws) ? msgpack_unpack($raws) : [];
        }
        return explode(',', $this->data[$type]);
    }

    /**
     * Refresh Cache
     * @param string $key
     */
    private function update(string $key): void
    {
        $queryLists = Db::table('role')
            ->where('status', '=', 1)
            ->get(['key', 'acl', 'resource']);

        if ($queryLists->isEmpty()) {
            return;
        }

        $lists = [];
        foreach ($queryLists->toArray() as $value) {
            $lists[$value->key] = msgpack_pack([
                'acl' => $value->acl,
                'resource' => $value->resource
            ]);
            if ($key == $value->key) {
                $this->data = [
                    'acl' => $value->acl,
                    'resource' => $value->resource
                ];
            }
        }
        $this->redis->hMSet($this->key, $lists);
    }
}