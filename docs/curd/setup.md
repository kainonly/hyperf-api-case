## 安装使用

辅助 Hyperf 快速集成 CURD API 的工具集，首先需要安装依赖库 `kain/hyperf-curd`

```shell
composer require kain/hyperf-curd
```

在 `config/autoload/dependencies.php` 内完成关系配置

```php
return [
    Hyperf\Curd\CurdInterface::class => Hyperf\Curd\CurdService::class,
];
```

可以定义一个顶层抽象类注入依赖，例如

```php
use Hyperf\Curd\CurdInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Extra\Hash\HashInterface;
use Hyperf\Extra\Token\TokenInterface;
use Hyperf\Extra\Utils\UtilsInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

abstract class BaseController
{
    /**
     * @Inject()
     * @var RequestInterface
     */
    protected RequestInterface $request;
    /**
     * @Inject()
     * @var ResponseInterface
     */
    protected ResponseInterface $response;
    /**
     * @Inject()
     * @var ValidatorFactoryInterface
     */
    protected ValidatorFactoryInterface $validation;
    /**
     * @Inject()
     * @var CurdInterface
     */
    protected CurdInterface $curd;
    /**
     * @Inject()
     * @var HashInterface
     */
    protected HashInterface $hash;
    /**
     * @Inject()
     * @var TokenInterface
     */
    protected TokenInterface $token;
    /**
     * @Inject()
     * @var UtilsInterface
     */
    protected UtilsInterface $utils;
}
```