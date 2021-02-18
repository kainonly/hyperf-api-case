<?php
declare (strict_types=1);

namespace App\RedisModel\System;

use Hyperf\DbConnection\Db;
use Hyperf\Extra\Redis\Library\AclLibrary;
use Hyperf\Extra\Redis\RedisModel;

class AclRedis extends RedisModel implements AclLibrary
{
    protected string $key = 'system:acl';

    /**
     * Clear Cache
     */
    public function clear(): void
    {
        $this->redis->del($this->getKey());
    }

    /**
     * Get Cache
     * @param string $key
     * @param int $policy
     * @return array
     */
    public function get(string $key, int $policy): array
    {
        if (!$this->redis->exists($this->getKey())) {
            $this->update();
        }

        $raws = $this->redis->hGet($this->getKey(), $key);
        $data = json_decode($raws, true);

        switch ($policy) {
            case 0:
                return $data['read'];
            case 1:
                return [
                    ...$data['read'],
                    ...$data['write']
                ];
            default:
                return [];
        }
    }

    /**
     * Refresh Cache
     */
    private function update(): void
    {
        $query = Db::table('acl')
            ->where('status', '=', 1)
            ->get(['key', 'write', 'read']);

        if ($query->isEmpty()) {
            return;
        }

        $lists = [];
        foreach ($query->toArray() as $value) {
            $lists[$value->key] = json_encode([
                'write' => !empty($value->write) ? explode(',', $value->write) : [],
                'read' => !empty($value->read) ? explode(',', $value->read) : []
            ]);
        }
        $this->redis->hMSet($this->getKey(), $lists);
    }
}