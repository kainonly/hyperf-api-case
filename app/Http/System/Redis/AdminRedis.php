<?php

namespace App\Http\System\Redis;

use Illuminate\Support\Facades\DB;
use lumen\extra\common\RedisModel;
use Predis\Pipeline\Pipeline;

class AdminRedis extends RedisModel
{
    protected $key = 'system:admin';
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
     * Get User Data
     * @param string $username Username
     * @return array
     */
    public function get(string $username)
    {
        if (!$this->redis->exists($this->key)) {
            $this->update($username);
        } else {
            $this->rows = json_decode($this->redis->hGet($this->key, $username), true);
        }
        return $this->rows;
    }

    /**
     * Update Redis
     * @param string $username
     */
    private function update(string $username)
    {

        $lists = DB::table('admin')
            ->where('status', '=', 1)
            ->get(['id', 'role', 'username', 'password']);

        if (empty($lists)) {
            return;
        }

        $this->redis->pipeline(function (Pipeline $pipeline) use ($username, $lists) {
            foreach ($lists as $key => $value) {
                $pipeline->hset($this->key, $value['username'], json_encode($value));
                if ($username == $value['username']) {
                    $this->rows = $value;
                }
            }
        });
    }
}
