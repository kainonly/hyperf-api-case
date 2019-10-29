<?php

namespace App\Http\System\Redis;

use Illuminate\Support\Facades\DB;
use Lumen\Support\Common\RedisModel;

class AclRedis extends RedisModel
{
    protected $key = 'system:acl';
    private $rows = [];

    /**
     * Clear Redis
     * @return bool
     */
    public function clear()
    {
        return (bool)$this->redis->del($this->key);
    }

    /**
     * @param string $key Access Control Key
     * @param int $policy Access Control Policy
     * @return array
     */
    public function get(string $key, int $policy)
    {
        if (!$this->redis->exists($this->key)) {
            $this->update($key);
        } else {
            $this->rows = json_decode($this->redis->hget($this->key, $key), true);
        }

        switch ($policy) {
            case 0:
                return explode(',', $this->rows['read']);
            case 1:
                return array_merge(
                    explode(',', $this->rows['read']),
                    explode(',', $this->rows['write'])
                );
            default:
                return [];
        }
    }

    /**
     * Update Redis
     * @param string $key Access Control Key
     */
    private function update(string $key)
    {
        $queryLists = DB::table('acl')
            ->where('status', '=', 1)
            ->get(['key', 'write', 'read']);

        if ($queryLists->isEmpty()) {
            return;
        }
        $lists = [];
        foreach ($queryLists->toArray() as $value) {
            $data[$value->key] = json_encode([
                'write' => $value->write,
                'read' => $value->read
            ]);
            if ($key == $value->key) {
                $this->rows = [
                    'write' => $value->write,
                    'read' => $value->read
                ];
            }
        }
        $this->redis->hMSet($this->key, $lists);
    }
}
