<?php

namespace App\Http\System\Redis;

use Illuminate\Support\Facades\DB;
use lumen\extra\common\RedisModel;
use Predis\Pipeline\Pipeline;

class Acl extends RedisModel
{
    protected $key = 'system:acl';

    /**
     * @return bool
     */
    public function refresh()
    {
        $this->redis->del([$this->key]);
        $lists = DB::table('acl')
            ->where('status', '=', 1)
            ->get(['key', 'write', 'read']);

        if (empty($lists)) {
            return true;
        }
        return !empty($this->redis->pipeline(
            function ($pipeline) use ($lists) {
                /**
                 * @var Pipeline $pipeline
                 */
                foreach ($lists as $key => $value) {
                    $pipeline->hset($this->key, $value->key, json_encode([
                        'write' => $value->write,
                        'read' => $value->read
                    ]));
                }
            })
        );
    }

    /**
     * @param string $url
     * @return mixed
     */
    public function get(string $url)
    {
        if (!$this->redis->exists($this->key)) {
            $this->refresh();
        }

        return json_decode($this->redis->hget($this->key, $url), true);
    }
}
