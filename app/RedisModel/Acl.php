<?php

namespace App\RedisModel;

use Hyperf\DbConnection\Db;
use Hyperf\Support\Common\RedisModel;

class Acl extends RedisModel
{
    protected $key = 'app:acl';
    private $rows = [];

    public function clear()
    {
        $this->redis->del($this->key);
    }

    public function get(string $key, int $policy)
    {
        if (!$this->redis->exists($this->key)) {
            $this->update($key);
        } else {
            $this->rows = json_decode($this->redis->hGet($this->key, $key), true);
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

    private function update(string $key)
    {
        $queryLists = Db::table('acl')
            ->where('status', '=', 1)
            ->get(['key', 'write', 'read']);

        if ($queryLists->isEmpty()) {
            return;
        }
        $lists = [];
        foreach ($queryLists->toArray() as $value) {
            $data[$value['key']] = json_encode([
                'write' => $value['write'],
                'read' => $value['read']
            ]);
            if ($key == $value['key']) {
                $this->rows = [
                    'write' => $value['write'],
                    'read' => $value['read']
                ];
            }
        }
        $this->redis->hMSet($this->key, $lists);
    }
}