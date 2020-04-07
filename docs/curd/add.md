## Add 新增数据

addValidation 与 addModel 是针对列表数据的通用请求处理

#### 基础用法

```php
use Hyperf\Curd\CurdInterface;
use Hyperf\Di\Annotation\Inject;

class ExampleController
{
    /**
     * @Inject()
     * @var CurdInterface
     */
    private CurdInterface $curd;

    public function add(): array
    {
        // <<预处理>>

        $validate = $this->curd->addValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }

        // <<前置处理>>

        return $this->curd
            ->addModel('example')
            ->result();
    }
}
```

#### addValidation(array $validate = [], ?array $default = null): ValidatorInterface

验证新增数据的请求 `body`

- **validate** `array` 自定义验证，作为默认验证的填充
- **default** `array` 默认验证，默认值为空

```php
[]
```

#### addModel(string $name, ?array $body = null): AddModel

生成新增数据的模型处理

- **name** `string` 表名称
- **body** `array` 请求 `body`，如果上游 `body` 做出更改可通过传参方式处理，例如

```php
use Hyperf\Curd\CurdInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\Str;

class ExampleController
{
    /**
     * @Inject()
     * @var RequestInterface
     */
    private RequestInterface $request;
    /**
     * @Inject()
     * @var CurdInterface
     */
    private CurdInterface $curd;

    public function add(): array
    {
        $body = $this->request->post();
        $validate = $this->curd->addValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }
        $body['random'] = Str::random();
        return $this->curd
            ->addModel('example', $body)
            ->result();
    }
}
```

#### AddModel 模型类

- **setAutoTimestamp(bool $value): self**
  - **value** `bool`

是否自动生成时间戳，默认设定字段 `create_time` 与 `update_time`，例如

```php
use Hyperf\Curd\CurdInterface;
use Hyperf\Di\Annotation\Inject;

class ExampleController
{
    /**
     * @Inject()
     * @var CurdInterface
     */
    private CurdInterface $curd;

    public function add(): array
    {
        $validate = $this->curd->addValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }
        return $this->curd
            ->addModel('example')
            ->setAutoTimestamp(false)
            ->result();
    }
}
```

- **afterHook(Closure $value): self**
  - **value** `Closure`

在写入数据事务中增加后置处理，例如

```php
use Hyperf\Curd\Common\AddAfterParams;
use Hyperf\Curd\CurdInterface;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Utils\Context;

class ExampleController
{
    /**
     * @Inject()
     * @var CurdInterface
     */
    private CurdInterface $curd;

    public function add(): array
    {
        $validate = $this->curd->addValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }
        return $this->curd
            ->addModel('example')
            ->afterHook(function (AddAfterParams $params) {
                $result = Db::table('example_sub')
                    ->insert([
                        'eid' => $params->getId(),
                        'name' => 'xxx'
                    ]);
                if (!$result) {
                    Context::set('error', [
                        'error' => 1,
                        'msg' => 'Sub data insert failed'
                    ]);
                    return false;
                }
                return true;
            })
            ->result();
    }
}
```

!> 后置处理的闭包返回值决定事务是否提交，如果为 `false` 将自动回滚