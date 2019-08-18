<?php

namespace App\Http\System\Redis;

use Illuminate\Support\Facades\DB;
use lumen\extra\common\RedisModel;
use Predis\Pipeline\Pipeline;

class Admin extends RedisModel
{
    protected $key = 'system:admin';

    /**
     * @return bool
     */
    public function refresh()
    {
        $this->redis->del([$this->key]);
        $lists = DB::table('admin')
            ->where('status', '=', 1)
            ->get(['id', 'role', 'username', 'password']);

        if (empty($lists)) {
            return true;
        }

        return !empty($this->redis->pipeline(
            function (Pipeline $pipeline) use ($lists) {
                foreach ($lists as $key => $value) {
                    $pipeline->hset(
                        $this->key,
                        $value['username'],
                        json_encode($value)
                    );
                }
            }
        ));
    }

    /**
     * @param string $username
     * @return mixed
     */
    public function get(string $username)
    {
        if (!$this->redis->exists($this->key)) {
            $this->refresh();
        }

        return json_decode($this->redis->hGet($this->key, $username), true);
    }
}
