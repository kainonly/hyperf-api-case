<?php
declare (strict_types=1);

namespace App\RedisModel\System;

use Hyperf\DbConnection\Db;
use Hyperf\Support\Common\RedisModel;

class AdminRedis extends RedisModel
{
    protected string $key = 'system:admin';
    private array $data;

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
            $this->update($username);
        } else {
            $raws = $this->redis->hGet($this->key, $username);
            $this->data = !empty($raws) ? msgpack_unpack($raws) : [];
        }
        return $this->data;
    }

    /**
     * Refresh Cache
     * @param string $username
     */
    private function update(string $username): void
    {
        $queryLists = Db::table('admin')
            ->where('status', '=', 1)
            ->get(['id', 'role', 'username', 'password']);

        if ($queryLists->isEmpty()) {
            return;
        }
        $lists = [];
        foreach ($queryLists->toArray() as $value) {
            $lists[$value->username] = msgpack_pack((array)$value);
            if ($username == $value->username) {
                $this->data = (array)$value;
            }
        }
        $this->redis->hMSet($this->key, $lists);
    }
}