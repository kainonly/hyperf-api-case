## RBAC 权限验证

RbacVerify 权限验证是一个抽象定义中间件，使用时需要根据场景继承定义，例如

```php
<?php
declare(strict_types=1);

namespace App\Middleware\System;

use Hyperf\Support\Middleware\RbacVerify as BaseRbacVerify;

class RbacVerify extends BaseRbacVerify
{
    protected string $prefix = 'system';
    protected array $ignore = [
        'valided*'
    ];
}
```

- **prefix** `string` url前缀
- **ignore** `array` 忽略的函数名

```php
AutoController(App\Controller\System\AclController::class, [
    'middleware' => [
        App\Middleware\System\AuthVerify::class,
        App\Middleware\System\RbacVerify::class
    ]
]);
```