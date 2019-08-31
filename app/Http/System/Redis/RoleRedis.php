<?php

namespace App\Http\System\Redis;

use Illuminate\Support\Facades\DB;
use lumen\extra\common\RedisModel;
use Predis\Pipeline\Pipeline;

class RoleRedis extends RedisModel
{
    protected $key = 'system:role';

    /**
     * @return bool
     */
    public function refresh()
    {
        $this->redis->del([$this->key]);
        $lists = DB::table('role')
            ->where('status', '=', 1)
            ->get(['key', 'acl', 'resource']);

        if (empty($lists)) {
            return true;
        }

        return !empty($this->redis->pipeline(
            function ($pipeline) use ($lists) {
                /**
                 * @var Pipeline $pipeline
                 */
                foreach ($lists as $key => $value) {
                    $pipeline->hset(
                        $this->key,
                        $value->key,
                        json_encode([
                            'acl' => $value->acl,
                            'resource' => $value->resource
                        ])
                    );
                }
            }
        ));
    }

    /**
     * @param string $roleKey
     * @return mixed
     */
    public function get(string $roleKey)
    {
        if (!$this->redis->exists($this->key)) {
            $this->refresh();
        }

        return json_decode($this->redis->hget($this->key, $roleKey), true);
    }

}
