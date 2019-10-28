<?php

namespace App\Http\System\Redis;

use Illuminate\Support\Facades\DB;
use lumen\extra\common\RedisModel;
use Predis\Pipeline\Pipeline;

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
        return (bool)$this->redis->del([$this->key]);
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
        $lists = DB::table('acl')
            ->where('status', '=', 1)
            ->get(['key', 'write', 'read']);

        if (empty($lists)) {
            return;
        }

        $this->redis->pipeline(function (Pipeline $pipeline) use ($key, $lists) {
            foreach ($lists as $index => $value) {
                $pipeline->hset($this->key, $value['key'], json_encode([
                    'write' => $value['write'],
                    'read' => $value['read']
                ]));
                if ($key == $value['key']) {
                    $this->rows = [
                        'write' => $value['write'],
                        'read' => $value['read']
                    ];
                }
            }
        });
    }
}
