## Edit 编辑数据

editValidation 与 editModel 是针对编辑数据的通用请求处理

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

    public function edit(): array
    {
        // <<预处理>>

        $validate = $this->curd->editValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }

        // <<前置处理>>

        return $this->curd
            ->editModel('example')
            ->result();
    }
}
```

#### editValidation(array $validate = [], ?array $default = null): ValidatorInterface

验证编辑数据的请求 `body`

- **validate** `array` 自定义验证，作为默认验证的填充
- **default** `array` 默认验证，默认值为空

```php
[
    'id' => 'required_without:where|integer',
    'switch' => 'required|bool',
    'where' => 'required_without:id|array',
    'where.*' => 'array|size:3'
]
```

请求 `body` 可使用 **id** 或 **where** 字段进行查询，二者选一

- **id** `int` 主键
- **switch** `bool` 是否为编辑状态
- **where** `array` 查询条件，必须使用数组查询方式来定义

#### editModel(string $name, ?array $body = null): EditModel

生成编辑数据的模型处理

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

    public function edit(): array
    {
        $body = $this->request->post();
        $validate = $this->curd->editValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }
        $body['random'] = Str::random();
        return $this->curd
            ->editModel('example', $body)
            ->result();
    }
}
```

#### EditModel 模型类

- **setAutoTimestamp(bool $value): self**
  - **value** `bool`

是否自动生成时间戳，默认设定字段 `update_time`，例如

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

    public function edit(): array
    {
        $validate = $this->curd->editValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }
        return $this->curd
            ->editModel('example')
            ->setAutoTimestamp(false)
            ->result();
    }
}
```

- **setCondition(array $value): self**
  - **value** `array` 条件数组

为此增加后端固定条件，例如

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

    public function edit(): array
    {
        $validate = $this->curd->editValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }
        return $this->curd
            ->editModel('example')
            ->setCondition([
                ['enterprise', '=', 10001]
            ])
            ->result();
    }
}
```

- **afterHook(Closure $value): self**
  - **value** `Closure`

在修改数据事务中增加后置处理，例如

```php
use Hyperf\Curd\Common\EditAfterParams;
use Hyperf\Curd\CurdInterface;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\Context;

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

    public function edit(): array
    {
        $body = $this->request->post();
        $validate = $this->curd->editValidation([
            'key' => 'required'
        ]);
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }
        $data = Db::table('another')
            ->where('key', '=', $body['key'])
            ->first();
        if (empty($data)) {
            return [
                'error' => 1,
                'msg' => 'not exists'
            ];
        }
        $body['xt'] = $data->xt;
        return $this->curd
            ->editModel('example', $body)
            ->afterHook(function (EditAfterParams $params) use ($data) {
                if (!$params->isSwitch()) {
                    $result = Db::table('example_sub')
                        ->insert([
                            'eid' => $params->getId(),
                            'data' => $data
                        ]);
                    if (!$result) {
                        Context::set('error', [
                            'error' => 1,
                            'msg' => 'Sub data insert failed'
                        ]);
                        return false;
                    }
                }
                return true;
            })
            ->result();
    }
}
```