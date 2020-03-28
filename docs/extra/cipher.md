## Cipher 数据加密

Cipher 可以将字符串或数组进行加密解密的服务，此服务必须安装 `kain/hyperf-extra`，需要配置 `config/config.php`

```php
return [

    'app_name' => env('APP_NAME', 'skeleton'),
    'app_key' => env('APP_KEY', '123456'),

];
```

- **app_name** `string` Cipher偏移量
- **app_key** `string` Cipher密钥

在 `config/autoload/dependencies.php` 内完成关系配置

```php
return [
    Hyperf\Extra\Cipher\CipherInterface::class => Hyperf\Extra\Cipher\CipherService::class,
];
```

即可注入使用

```php
use Hyperf\Extra\Cipher\CipherInterface;

class IndexController
{
    public function index(CipherInterface $cipher)
    {
        $cipher->encrypt('123');
    }
}
```

也可以使用注解方式

```php
use Hyperf\Di\Annotation\Inject;
use Hyperf\Extra\Cipher\CipherInterface;

class IndexController
{
    /**
     * @Inject()
     * @var CipherInterface
     */
    private CipherInterface $cipher;

    public function index()
    {
        $this->cipher->encrypt('123');
    }
}
```

#### encrypt($context)

加密数据

- **context** `string|array` 数据
- **Return** `string` 密文

```php
use Hyperf\Di\Annotation\Inject;
use Hyperf\Extra\Cipher\CipherInterface;

class IndexController
{
    /**
     * @Inject()
     * @var CipherInterface
     */
    private CipherInterface $cipher;

    public function index()
    {
        $this->cipher->encrypt(['name' => 'kain']);
        // XMqRFrrGduqqY3sEyKiHJQ==
    }
}
```

#### decrypt(string $ciphertext, bool $auto_conver = true)

解密数据

- **ciphertext** `string` 密文
- **auto_conver** `bool` 数据属于数组时是否自动转换
- **Return** `string|array` 明文

```php
use Hyperf\Di\Annotation\Inject;
use Hyperf\Extra\Cipher\CipherInterface;

class IndexController
{
    /**
     * @Inject()
     * @var CipherInterface
     */
    private CipherInterface $cipher;

    public function index()
    {
        $this->cipher->decrypt('XMqRFrrGduqqY3sEyKiHJQ==');
        // array(1) {
        //     ["name"]=>
        //     string(4) "kain"
        // }
    }
}
```