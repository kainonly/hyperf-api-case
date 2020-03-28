## Auth 鉴权验证

AuthVerify 鉴权验证是一个抽象定义中间件，使用时需要根据场景继承定义，例如

```php
<?php
declare(strict_types=1);

namespace App\Middleware\System;

use Hyperf\Support\Middleware\AuthVerify as BaseAuthVerify;

class AuthVerify extends BaseAuthVerify
{
    protected string $scene = 'system';
}
```

- **scene** `string` 场景标签

然后在将中间件注册在路由中

```php
AutoController(App\Controller\System\MainController::class, [
    'middleware' => [
        App\Middleware\System\AuthVerify::class => [
            'resource', 'information', 'update', 'uploads'
        ]
    ]
]);
```