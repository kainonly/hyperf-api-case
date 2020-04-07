## Get 获取单个数据

getValidation 与 getModel 是针对获取单条数据的通用请求处理

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

    public function get(): array
    {
        // <<预处理>>

        $validate = $this->curd->getValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }

        // <<前置处理>>

        $result = $this->curd
            ->getModel('example')
            ->result();

        // <<后置处理>>

        return $result;
    }
}
```

#### getValidation(array $validate = [], ?array $default = null): ValidatorInterface

验证获取单个数据的请求 `body`

- **validate** `array` 自定义验证，作为默认验证的填充
- **default** `array` 默认验证，默认值为

```php
[
    'id' => 'required_without:where|integer',
    'where' => 'required_without:id|array',
    'where.*' => 'array|size:3'
]
```

请求 `body` 可使用 **id** 或 **where** 字段进行查询，二者选一

- **id** `int` 主键
- **where** `array` 查询条件，必须使用数组查询方式来定义，例如

```json
{
    "where":[
        ["name", "=", "van"]
    ]
}
```

如果查询条件为 JSON ，可以完全依照 Laravel Query Builder

```json
{
    "where":[
        ["extra->nickname", "=", "kain"]
    ]
}
```

#### getModel(string $name, ?array $body = null): GetModel

生成获取单个数据的模型处理

- **name** `string` 表名称
- **body** `array` 请求 `body`，如果上游 `body` 做出更改可通过传参方式处理，例如

```php
use Hyperf\Curd\CurdInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

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

    public function get(): array
    {
        $body = $this->request->post();
        $validate = $this->curd->getValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }
        unset($body['where']);
        return $this->curd
            ->getModel('example', $body)
            ->result();
    }
}
```

#### GetModel 模型类

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

    public function get(): array
    {
        $validate = $this->curd->getValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }
        return $this->curd
            ->getModel('example')
            ->setCondition([
                ['enterprise', '=', 10001]
            ])
            ->result();
    }
}
```

- **setField(array $value): self**
  - **value** `array` 字段数组

设置限制字段，例如

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

    public function get(): array
    {
        $validate = $this->curd->getValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }
        return $this->curd
            ->getModel('example')
            ->setField(['id', 'name'])
            ->result();
    }
}
```