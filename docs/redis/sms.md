## SMS 短信验证

手机短信验证码缓存类

#### factory($phone, $code, $timeout = 120): bool

设置手机验证码缓存

- **phone** `string` 手机号
- **code** `string` 验证码
- **timeout** `int` 超时时间，默认60秒
- **Return** `bool`

```php
use Hyperf\Di\Annotation\Inject;
use Hyperf\Support\RedisModel\Sms;

class IndexController
{
    /**
     * @Inject()
     * @var Sms
     */
    private Sms $smsRedis;

    public function index()
    {
        $this->smsRedis->factory('12345678910', '13125');
    }
}
```

#### check($phone, $code, $once = false): bool

验证手机验证码

- **phone** `string` 手机号
- **code** `string` 验证码
- **once** `bool` 验证成功后失效，默认`false`
- **Return** `bool`

```php
use Hyperf\Di\Annotation\Inject;
use Hyperf\Support\RedisModel\Sms;

class IndexController
{
    /**
     * @Inject()
     * @var Sms
     */
    private Sms $smsRedis;

    public function index()
    {
        $this->smsRedis->check('12345678910', '13125');
    }
}

```

#### time($phone): array

获取验证时间

- **phone** `string` 手机号
- **Return** `bool|array`

```php
use Hyperf\Di\Annotation\Inject;
use Hyperf\Support\RedisModel\Sms;

class IndexController
{
    /**
     * @Inject()
     * @var Sms
     */
    private Sms $smsRedis;

    public function index()
    {
        $this->smsRedis->time('12345678910');
    }
}

```

- **publish_time** `int` 指发布时间
- **timeout** `int` 指有效时间