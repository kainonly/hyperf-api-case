## Token 令牌

Token 是 JSON Web Token 方案的功能服务，此服务必须安装 `kain/hyperf-extra`，首先更新配置 `config/autoload/token.php`

```php
return [
    'system' => [
        'issuer' => 'api.kainonly.com',
        'audience' => 'console.kainonly.com',
        'expires' => 3600
    ],
];
```

当中 `system` 就是 `Token` 的 Label 标签，可以自行定义名称

- **issuer** `string` 发行者
- **audience** `string` 听众
- **expires** `int` 有效时间

在 `config/autoload/dependencies.php` 内完成关系配置

```php
return [
    Hyperf\Extra\Token\TokenInterface::class => Hyperf\Extra\Token\TokenService::class,
];
```

即可注入使用

```php
use Hyperf\Extra\Token\TokenInterface;
use Hyperf\Utils\Str;
use stdClass;

class IndexController
{

    public function index(TokenInterface $token)
    {
        $symbol = new stdClass();
        $symbol->role = '*';
        $token->create('system', Str::random(), Str::random(8), $symbol);
    }
}
```

也可以使用注解方式

```php
use Hyperf\Di\Annotation\Inject;
use Hyperf\Extra\Token\TokenInterface;
use Hyperf\Utils\Str;
use stdClass;

class IndexController
{
    /**
     * @Inject()
     * @var TokenInterface
     */
    private TokenInterface $token;

    public function index()
    {
        $symbol = new stdClass();
        $symbol->role = '*';
        $this->token->create('system', Str::random(), Str::random(8), $symbol);
    }
}
```

#### create(string $scene, string $jti, string $ack, ?stdClass $symbol): Token

生成令牌

- **scene** `string` 场景标签
- **jti** `string` Token ID
- **ack** `string` Token 确认码
- **symbol** `array` 标识组
- **Return** `\Lcobucci\JWT\Token`

```php
use Hyperf\Di\Annotation\Inject;
use Hyperf\Extra\Token\TokenInterface;
use Hyperf\Utils\Str;
use stdClass;

class IndexController
{
    /**
     * @Inject()
     * @var TokenInterface
     */
    private TokenInterface $token;

    public function index()
    {
        $symbol = new stdClass();
        $symbol->role = '*';
        $token = $this->token->create('system', Str::random(), Str::random(8), $symbol);
        var_dump((string)$token);
    }
}

// "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6InNMYW1vdkRMcFpMaTBKMzIifQ.eyJpc3MiOiJhcGkua2Fpbm9ubHkuY29tIiwiYXVkIjoiY29uc29sZS5rYWlub25seS5jb20iLCJqdGkiOiJzTGFtb3ZETHBaTGkwSjMyIiwiYWNrIjoiZlUxeUN6U2ciLCJzeW1ib2wiOnsicm9sZSI6IioifSwiZXhwIjoxNTg1MzY1MDUzfQ.zkamZXgUaqOTZEn8JBBo-8k3oZAzuU7zWH-ZtNJjagA"
```

#### get(string $tokenString): Token

获取令牌对象

- **tokenString** `string` 字符串令牌
- **Return** `\Lcobucci\JWT\Token`

```php
use Hyperf\Di\Annotation\Inject;
use Hyperf\Extra\Token\TokenInterface;

class IndexController
{
    /**
     * @Inject()
     * @var TokenInterface
     */
    private TokenInterface $token;

    public function index()
    {
        $tokenString = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6InNMYW1vdkRMcFpMaTBKMzIifQ.eyJpc3MiOiJhcGkua2Fpbm9ubHkuY29tIiwiYXVkIjoiY29uc29sZS5rYWlub25seS5jb20iLCJqdGkiOiJzTGFtb3ZETHBaTGkwSjMyIiwiYWNrIjoiZlUxeUN6U2ciLCJzeW1ib2wiOnsicm9sZSI6IioifSwiZXhwIjoxNTg1MzY1MDUzfQ.zkamZXgUaqOTZEn8JBBo-8k3oZAzuU7zWH-ZtNJjagA';
        $token = $this->token->get($tokenString);
        var_dump($token);
    }
}

//    object(Lcobucci\JWT\Token)#6546 (4) {
//    ["headers":"Lcobucci\JWT\Token":private]=>
//    array(3) {
//        ["typ"]=>
//        string(3) "JWT"
//        ["alg"]=>
//        string(5) "HS256"
//        ["jti"]=>
//        object(Lcobucci\JWT\Claim\EqualsTo)#6541 (2) {
//        ["name":"Lcobucci\JWT\Claim\Basic":private]=>
//        string(3) "jti"
//        ["value":"Lcobucci\JWT\Claim\Basic":private]=>
//        string(16) "sLamovDLpZLi0J32"
//        }
//    }
//    ["claims":"Lcobucci\JWT\Token":private]=>
//    array(6) {
//        ["iss"]=>
//        object(Lcobucci\JWT\Claim\EqualsTo)#6538 (2) {
//        ["name":"Lcobucci\JWT\Claim\Basic":private]=>
//        string(3) "iss"
//        ["value":"Lcobucci\JWT\Claim\Basic":private]=>
//        string(16) "api.kainonly.com"
//        }
//        ["aud"]=>
//        object(Lcobucci\JWT\Claim\EqualsTo)#6540 (2) {
//        ["name":"Lcobucci\JWT\Claim\Basic":private]=>
//        string(3) "aud"
//        ["value":"Lcobucci\JWT\Claim\Basic":private]=>
//        string(20) "console.kainonly.com"
//        }
//        ["jti"]=>
//        object(Lcobucci\JWT\Claim\EqualsTo)#6541 (2) {
//        ["name":"Lcobucci\JWT\Claim\Basic":private]=>
//        string(3) "jti"
//        ["value":"Lcobucci\JWT\Claim\Basic":private]=>
//        string(16) "sLamovDLpZLi0J32"
//        }
//        ["ack"]=>
//        object(Lcobucci\JWT\Claim\Basic)#6542 (2) {
//        ["name":"Lcobucci\JWT\Claim\Basic":private]=>
//        string(3) "ack"
//        ["value":"Lcobucci\JWT\Claim\Basic":private]=>
//        string(8) "fU1yCzSg"
//        }
//        ["symbol"]=>
//        object(Lcobucci\JWT\Claim\Basic)#6543 (2) {
//        ["name":"Lcobucci\JWT\Claim\Basic":private]=>
//        string(6) "symbol"
//        ["value":"Lcobucci\JWT\Claim\Basic":private]=>
//        object(stdClass)#6539 (1) {
//            ["role"]=>
//            string(1) "*"
//        }
//        }
//        ["exp"]=>
//        object(Lcobucci\JWT\Claim\GreaterOrEqualsTo)#6544 (2) {
//        ["name":"Lcobucci\JWT\Claim\Basic":private]=>
//        string(3) "exp"
//        ["value":"Lcobucci\JWT\Claim\Basic":private]=>
//        int(1585365053)
//        }
//    }
//    ["signature":"Lcobucci\JWT\Token":private]=>
//    object(Lcobucci\JWT\Signature)#6545 (1) {
//        ["hash":protected]=>
//        string(32) "FexjdI$h73NXcj "
//    }
//    ["payload":"Lcobucci\JWT\Token":private]=>
//    array(3) {
//        [0]=>
//        string(70) "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6InNMYW1vdkRMcFpMaTBKMzIifQ"
//        [1]=>
//        string(182) //"eyJpc3MiOiJhcGkua2Fpbm9ubHkuY29tIiwiYXVkIjoiY29uc29sZS5rYWlub25seS5jb20iLCJqdGkiOiJzTGFtb3ZETHBaTGkwSjMyIiwiYWNrIjoiZlUxeUN6U2ciLCJzeW1ib2wiOnsicm9sZSI6IioifSwiZXhwIjoxNTg1MzY//1MDUzfQ"
//        [2]=>
//        string(43) "zkamZXgUaqOTZEn8JBBo-8k3oZAzuU7zWH-ZtNJjagA"
//    }
//    }
```

#### verify(string $scene, string $tokenString): stdClass

验证令牌有效性

- **scene** `string` 场景标签
- **tokenString** `string` 字符串令牌
- **Return** `stdClass`
  - **expired** `bool` 是否过期
  - **token** `\Lcobucci\JWT\Token` 令牌对象

```php
use Hyperf\Di\Annotation\Inject;
use Hyperf\Extra\Token\TokenInterface;

class IndexController
{
    /**
     * @Inject()
     * @var TokenInterface
     */
    private TokenInterface $token;

    public function index()
    {
        $tokenString = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6InNMYW1vdkRMcFpMaTBKMzIifQ.eyJpc3MiOiJhcGkua2Fpbm9ubHkuY29tIiwiYXVkIjoiY29uc29sZS5rYWlub25seS5jb20iLCJqdGkiOiJzTGFtb3ZETHBaTGkwSjMyIiwiYWNrIjoiZlUxeUN6U2ciLCJzeW1ib2wiOnsicm9sZSI6IioifSwiZXhwIjoxNTg1MzY1MDUzfQ.zkamZXgUaqOTZEn8JBBo-8k3oZAzuU7zWH-ZtNJjagA';
        $result = $this->token->verify('system', $tokenString);
        var_dump($result);
    }
}

//    object(stdClass)#6529 (2) {
//    ["expired"]=>
//    bool(false)
//    ["token"]=>
//    object(Lcobucci\JWT\Token)#6542 (4) {
//        ["headers":"Lcobucci\JWT\Token":private]=>
//        array(3) {
//        ["typ"]=>
//        string(3) "JWT"
//        ["alg"]=>
//        string(5) "HS256"
//        ["jti"]=>
//        object(Lcobucci\JWT\Claim\EqualsTo)#6537 (2) {
//            ["name":"Lcobucci\JWT\Claim\Basic":private]=>
//            string(3) "jti"
//            ["value":"Lcobucci\JWT\Claim\Basic":private]=>
//            string(16) "sLamovDLpZLi0J32"
//        }
//        }
//        ["claims":"Lcobucci\JWT\Token":private]=>
//        array(6) {
//        ["iss"]=>
//        object(Lcobucci\JWT\Claim\EqualsTo)#6534 (2) {
//            ["name":"Lcobucci\JWT\Claim\Basic":private]=>
//            string(3) "iss"
//            ["value":"Lcobucci\JWT\Claim\Basic":private]=>
//            string(16) "api.kainonly.com"
//        }
//        ["aud"]=>
//        object(Lcobucci\JWT\Claim\EqualsTo)#6536 (2) {
//            ["name":"Lcobucci\JWT\Claim\Basic":private]=>
//            string(3) "aud"
//            ["value":"Lcobucci\JWT\Claim\Basic":private]=>
//            string(20) "console.kainonly.com"
//        }
//        ["jti"]=>
//        object(Lcobucci\JWT\Claim\EqualsTo)#6537 (2) {
//            ["name":"Lcobucci\JWT\Claim\Basic":private]=>
//            string(3) "jti"
//            ["value":"Lcobucci\JWT\Claim\Basic":private]=>
//            string(16) "sLamovDLpZLi0J32"
//        }
//        ["ack"]=>
//        object(Lcobucci\JWT\Claim\Basic)#6538 (2) {
//            ["name":"Lcobucci\JWT\Claim\Basic":private]=>
//            string(3) "ack"
//            ["value":"Lcobucci\JWT\Claim\Basic":private]=>
//            string(8) "fU1yCzSg"
//        }
//        ["symbol"]=>
//        object(Lcobucci\JWT\Claim\Basic)#6539 (2) {
//            ["name":"Lcobucci\JWT\Claim\Basic":private]=>
//            string(6) "symbol"
//            ["value":"Lcobucci\JWT\Claim\Basic":private]=>
//            object(stdClass)#6535 (1) {
//            ["role"]=>
//            string(1) "*"
//            }
//        }
//        ["exp"]=>
//        object(Lcobucci\JWT\Claim\GreaterOrEqualsTo)#6540 (2) {
//            ["name":"Lcobucci\JWT\Claim\Basic":private]=>
//            string(3) "exp"
//            ["value":"Lcobucci\JWT\Claim\Basic":private]=>
//            int(1585365053)
//        }
//        }
//        ["signature":"Lcobucci\JWT\Token":private]=>
//        object(Lcobucci\JWT\Signature)#6541 (1) {
//        ["hash":protected]=>
//        string(32) "FexjdI$h73NXcj "
//        }
//        ["payload":"Lcobucci\JWT\Token":private]=>
//        array(3) {
//        [0]=>
//        string(70) "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6InNMYW1vdkRMcFpMaTBKMzIifQ"
//        [1]=>
//        string(182) //"eyJpc3MiOiJhcGkua2Fpbm9ubHkuY29tIiwiYXVkIjoiY29uc29sZS5rYWlub25seS5jb20iLCJqdGkiOiJzTGFtb3ZETHBaTGkwSjMyIiwiYWNrIjoiZlUxeUN6U2ciLCJzeW1ib2wiOnsicm9sZSI6IioifSwiZXhwIjoxNTg1MzY//1MDUzfQ"
//        [2]=>
//        string(43) "zkamZXgUaqOTZEn8JBBo-8k3oZAzuU7zWH-ZtNJjagA"
//        }
//    }
//    }

```