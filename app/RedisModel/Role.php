<?php

namespace App\RedisModel;

use Hyperf\DbConnection\Db;
use Hyperf\Support\Common\RedisModel;

class Role extends RedisModel
{
    protected $key = 'app:role';
    private $rows = [];

    public function clear()
    {
        $this->redis->del($this->key);
    }

    public function get(string $key, string $type)
    {
        if (!$this->redis->exists($this->key)) {
            $this->update($key);
        } else {
            $this->rows = json_decode($this->redis->hget($this->key, $key), true);
        }
        return explode(',', $this->rows[$type]);
    }

    private function update(string $key)
    {
        $queryLists = Db::table('role')
            ->where('status', '=', 1)
            ->get(['key', 'acl', 'resource']);

        if ($queryLists->isEmpty()) {
            return;
        }

        $lists = [];
        foreach ($queryLists->toArray() as $value) {
            $lists[$value['key']] = json_encode([
                'acl' => $value['acl'],
                'resource' => $value['resource']
            ]);
            if ($key == $value['key']) {
                $this->rows = [
                    'acl' => $value['acl'],
                    'resource' => $value['resource']
                ];
            }
        }
        $this->redis->hMSet($this->key, $lists);
    }
}