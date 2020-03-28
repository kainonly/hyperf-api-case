## RedisModel 缓存模型

使用 RedisModel 定义缓存模型，目的是将分散的缓存操作统一定义，例如：设定Acl访问控制表的缓存模型

```php
class AclRedis extends RedisModel
{
    protected string $key = 'system:acl';

    /**
     * Clear Cache
     */
    public function clear(): void
    {
        $this->redis->del($this->key);
    }

    /**
     * Get Cache
     * @param string $key
     * @param int $policy
     * @return array
     */
    public function get(string $key, int $policy): array
    {
        if (!$this->redis->exists($this->key)) {
            $this->update();
        }

        $raws = $this->redis->hGet($this->key, $key);
        $data = !empty($raws) ? json_decode($raws, true) : [];

        switch ($policy) {
            case 0:
                return explode(',', $data['read']);
            case 1:
                return [
                    ...explode(',', $data['read']),
                    ...explode(',', $data['write'])
                ];
            default:
                return [];
        }
    }

    /**
     * Refresh Cache
     */
    private function update(): void
    {
        $query = Db::table('acl')
            ->where('status', '=', 1)
            ->get(['key', 'write', 'read']);

        if ($query->isEmpty()) {
            return;
        }

        $lists = [];
        foreach ($query->toArray() as $value) {
            $lists[$value->key] = json_encode([
                'write' => $value->write,
                'read' => $value->read
            ]);
        }
        $this->redis->hMSet($this->key, $lists);
    }
}
```

当对应的 `acl` 表数据发生变更时，执行 `clear()` 来清除缓存

```php
use App\RedisModel\System\AclRedis;
use Hyperf\Di\Annotation\Inject;

class IndexController
{
    /**
     * @Inject()
     * @var AclRedis
     */
    private AclRedis $aclRedis;

    public function index()
    {
        $this->aclRedis->clear();
    }
}
```

通过缓存模型自定义的获取规则获取对应的数据，例如：查访问键 `admin` 对应的数据，如缓存不存在则生成缓存并返回数据

```php
use App\RedisModel\System\AdminRedis;
use Hyperf\Di\Annotation\Inject;

class IndexController
{
    /**
     * @Inject()
     * @var AdminRedis
     */
    private AdminRedis $adminRedis;

    public function index()
    {
        $data = $this->adminRedis->get('kain');
    }
}
```