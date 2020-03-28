## CORS 跨站设置

使用CORS中间定义跨站的请求策略，你需要在主配置或对应的模块下创建配置 `config/autoload/cors.php`，例如：

```php
return [
    'allowed_methods' => explode(',', env('CORS_METHODS', '*')),
    'allowed_origins' => explode(',', env('CORS_ORIGINS', '*')),
    'allowed_headers' => explode(',', env('CORS_HEADERS', 'CONTENT-TYPE,X-REQUESTED-WITH')),
    'exposed_headers' => explode(',', env('CORS_EXPOSED_HEADERS', '')),
    'max_age' => (int)env('CORS_MAX_AGE', 0),
    'allowed_credentials' => env('CORS_CREDENTIALS', false),
];
```

- **allowed_methods** `array` 允许使用的 HTTP 方法
- **allowed_origins** `array` 允许访问该资源的外域 URI，对于不需要携带身份凭证的请求
- **allowed_headers** `string` 允许携带的首部字段
- **exposed_headers** `array` 允许浏览器访问的头放入白名单
- **max_age** `int` preflight请求的结果能够被缓存多久
- **allowed_credentials** `boolean` 允许浏览器读取response的内容


在 `config/autoload/dependencies.php` 内完成关系配置

```php
return [
    Hyperf\Extra\Cors\CorsInterface::class => Hyperf\Extra\Cors\CorsService::class
];
```

加入 `/system` 的路由组

```php
Router::addGroup('/system', function () {

}, [
    'middleware' => [
        Hyperf\Extra\Cors\Cors::class
    ]
]);
```