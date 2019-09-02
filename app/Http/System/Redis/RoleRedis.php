<?php

namespace App\Http\System\Redis;

use Illuminate\Support\Facades\DB;
use lumen\extra\common\RedisModel;
use Predis\Pipeline\Pipeline;

class RoleRedis extends RedisModel
{
    protected $key = 'system:role';
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
     * Get Role Data
     * @param string $key Role Key
     * @param string $type Role Type
     * @return array
     */
    public function get(string $key, string $type)
    {
        if (!$this->redis->exists($this->key)) {
            $this->update($key);
        } else {
            $this->rows = json_decode($this->redis->hget($this->key, $key), true);
        }
        return explode(',', $this->rows[$type]);
    }

    /**
     * Update Redis
     */
    private function update(string $key)
    {

        $lists = DB::table('role')
            ->where('status', '=', 1)
            ->get(['key', 'acl', 'resource']);

        if (empty($lists)) {
            return;
        }

        $this->redis->pipeline(function (Pipeline $pipeline) use ($key, $lists) {
            foreach ($lists as $key => $value) {
                $pipeline->hset($this->key, $value['key'], json_encode([
                    'acl' => $value['acl'],
                    'resource' => $value['resource']
                ]));
                if ($key == $value['key']) {
                    $this->rows = [
                        'acl' => $value['acl'],
                        'resource' => $value['resource']
                    ];
                }
            }
        });
    }
}
