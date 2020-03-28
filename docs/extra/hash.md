## Hash 密码

Hash 用于密码加密与验证，此服务必须安装 `kain/hyperf-extra`，需要添加配置 `config/autoload/hashing.php`

```php
<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Default Hash Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default hash driver that will be used to hash
    | passwords for your application. By default, the bcrypt algorithm is
    | used; however, you remain free to modify this option if you wish.
    |
    | Supported: "bcrypt", "argon", "argon2id"
    |
    */

    'driver' => 'argon2id',

    /*
    |--------------------------------------------------------------------------
    | Bcrypt Options
    |--------------------------------------------------------------------------
    |
    | Here you may specify the configuration options that should be used when
    | passwords are hashed using the Bcrypt algorithm. This will allow you
    | to control the amount of time it takes to hash the given password.
    |
    */

    'bcrypt' => [
        'rounds' => env('BCRYPT_ROUNDS', 10),
    ],

    /*
    |--------------------------------------------------------------------------
    | Argon Options
    |--------------------------------------------------------------------------
    |
    | Here you may specify the configuration options that should be used when
    | passwords are hashed using the Argon algorithm. These will allow you
    | to control the amount of time it takes to hash the given password.
    |
    */

    'argon' => [
        'memory' => 1024,
        'threads' => 2,
        'time' => 2,
    ],

];
```

- **driver** `bcrypt|argon|argon2id` 加密算法
- **bcrypt** `array` bcrypt 的配置
- **argon** `array` argon2i 与 argon2id 的配置

在 `config/autoload/dependencies.php` 内完成关系配置

```php
return [
    Hyperf\Extra\Hash\HashInterface::class => Hyperf\Extra\Hash\HashService::class,
];
```

即可注入使用

```php
use Hyperf\Extra\Hash\HashInterface;

class IndexController
{
    public function index(HashInterface $hash)
    {
        return [
            'hash' => $hash->create('test')
        ];
    }
}
```

也可以使用注解方式

```php
use Hyperf\Di\Annotation\Inject;
use Hyperf\Extra\Hash\HashInterface;

class IndexController
{
    /**
     * @Inject()
     * @var HashInterface
     */
    private HashInterface $hash;

    public function index()
    {
        return [
            'hash' => $this->hash->create('test')
        ];
    }
}
```

#### create($password, $options = [])

加密密码

- **password** `string` 密码
- **options** `array` 加密参数

```php
use Hyperf\Di\Annotation\Inject;
use Hyperf\Extra\Hash\HashInterface;

class IndexController
{
    /**
     * @Inject()
     * @var HashInterface
     */
    private HashInterface $hash;

    public function index()
    {
        $hashPassword = $this->hash->create('test');
        // $argon2id$v=19$m=65536,t=4,p=1$Z09laTVhVWRnN1E0RzNqUg$XmHfnX0Kol3EOO5WnVTAWSnkstkDsEGfCCSbUWGgUMU
    }
}
```

#### check($password, $hashPassword)

验证密码

- **password** `string` 密码
- **hashPassword** `string` 密码散列值

```php
use Hyperf\Di\Annotation\Inject;
use Hyperf\Extra\Hash\HashInterface;

class IndexController
{
    /**
     * @Inject()
     * @var HashInterface
     */
    private HashInterface $hash;

    public function index()
    {
        $hashPassword = '$argon2id$v=19$m=65536,t=4,p=1$Z09laTVhVWRnN1E0RzNqUg$XmHfnX0Kol3EOO5WnVTAWSnkstkDsEGfCCSbUWGgUMU';
        $this->hash->check('test', $hashPassword);
        // true
    }
}
```