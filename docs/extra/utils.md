## Utils 工具集

Utils 常用工具集合，此服务必须安装 `kain/hyperf-extra`，在 `config/autoload/dependencies.php` 内完成关系配置

```php
return [
    Hyperf\Extra\Utils\UtilsInterface::class => Hyperf\Extra\Utils\UtilsService::class,
];
```

#### cookie(string $name, string $value, array $options = []): Cookie

- **name** `string` Cookie 名称
- **value** `string` 值
- **options** `array` 配置

配置将以 `config/autoload/cookie.php` 作为基础

```php
return [
    'expire' => (int)env('COOKIE_EXPIRE', 0),
    'path' => env('COOKIE_PATH', '/'),
    'domain' => env('COOKIE_DOMAIN', ''),
    'secure' => (bool)env('COOKIE_SECURE', false),
    'httponly' => (bool)env('COOKIE_HTTPONLY', false),
    'raw' => true,
    'samesite' => env('COOKIE_SAMESITE', null),
];
```

返回携带Cookie的请求

```php
use Hyperf\Di\Annotation\Inject;
use Hyperf\Extra\Utils\UtilsInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

class IndexController
{
    /**
     * @Inject()
     * @var ResponseInterface
     */
    private ResponseInterface $response;
    /**
     * @Inject()
     * @var UtilsInterface
     */
    private UtilsInterface $utils;

    public function index()
    {
        $cookie = $this->utils->cookie('name', 'kain');
        return $this->response->withCookie($cookie)->json([
            'error' => 0,
            'msg' => 'ok'
        ]);
    }
}
```