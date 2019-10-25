<?php

namespace App\RedisModel;

use Hyperf\DbConnection\Db;
use Hyperf\Support\Common\RedisModel;

class Admin extends RedisModel
{
    protected $key = 'app:admin';
    private $rows = [];

    public function clear()
    {
        $this->redis->del($this->key);
    }

    public function get(string $username)
    {
        if (!$this->redis->exists($this->key)) {
            $this->update($username);
        } else {
            $this->rows = json_decode($this->redis->hGet($this->key, $username), true);
        }
        return $this->rows;
    }

    private function update(string $username)
    {

        $queryLists = Db::table('admin')
            ->where('status', '=', 1)
            ->get(['id', 'role', 'username', 'password']);

        if ($queryLists->isEmpty()) {
            return;
        }

        $lists = [];
        foreach ($queryLists->toArray() as $value) {
            $lists[$value['username']] = json_encode($value);
            if ($username == $value['username']) {
                $this->rows = $value;
            }
        }
        $this->redis->hMSet($this->key, $lists);
    }

}