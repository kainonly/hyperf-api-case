<?php

namespace App\Http\System\Redis;

use Illuminate\Support\Facades\DB;
use Lumen\Support\Common\RedisModel;

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
        return (bool)$this->redis->del($this->key);
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
        $queryLists = DB::table('admin')
            ->where('status', '=', 1)
            ->get(['id', 'role', 'username', 'password']);

        if ($queryLists->isEmpty()) {
            return;
        }
        $lists = [];
        foreach ($queryLists->toArray() as $value) {
            $lists[$value->username] = json_encode($value);
            if ($username == $value->username) {
                $this->rows = $value;
            }
        }
        $this->redis->hMSet($this->key, $lists);
    }
}
