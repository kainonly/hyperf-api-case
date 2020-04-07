## Lists 获取分页数据

listsValidation 与 listsModel 是针对分页数据的通用请求处理

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

    public function lists(): array
    {
        // <<预处理>>

        $validate = $this->curd->listsValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }

        // <<前置处理>>

        $result = $this->curd
            ->listsModel('example')
            ->result();

        // <<后置处理>>

        return $result;
    }
}
```

#### listsValidation(array $validate = [], ?array $default = null): ValidatorInterface

验证获取分页数据的请求 `body`

- **validate** `array` 自定义验证，作为默认验证的填充
- **default** `array` 默认验证，默认值为

```php
[
    'page' => 'required',
    'page.limit' => 'required|integer|between:1,50',
    'page.index' => 'required|integer|min:1',
    'where' => 'sometimes|array',
    'where.*' => 'array|size:3'
]
```

请求 `body` 使用数组查询方式来定义

- **page** 分页字段
  - **limit** `int` 长度限制
  - **index** `int` 分页页码
- **where** `array` 查询条件，必须使用数组查询方式来定义，例如

```json
{
    "page": {
        "limit": 20,
        "index": 1
    }
    "where": [
        ["name","=","van"]
    ]
}
```

如果查询条件为 JSON ，可以完全依照 Laravel Query Builder

```json
{
    "page": {
        "limit": 20,
        "index": 1
    }
    "where": [
        ["extra->nickname", "=", "kain"]
    ]
}
```

例如列表常用的模糊查询

```json
{
    "page": {
        "limit": 20,
        "index": 1
    }
    "where": [
        ["name", "like", "%v%"]
    ]
}
```

#### listsModel(string $name, ?array $body = null): ListsModel

生成获取分页数据的模型处理

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

    public function lists(): array
    {
        $body = $this->request->post();
        $validate = $this->curd->listsValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }
        unset($body['where']);
        return $this->curd
            ->listsModel('example', $body)
            ->result();
    }
}
```

#### ListsModel 模型类

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

    public function lists(): array
    {
        $validate = $this->curd->listsValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }
        return $this->curd
            ->listsModel('example')
            ->setCondition([
                ['enterprise', '=', 10001]
            ])
            ->result();
    }
}
```

- **setSubQuery(Closure $value): self**
  - **value** `Closure` 子查询

为此增加子查询条件，例如

```php
use Hyperf\Curd\CurdInterface;
use Hyperf\Database\Query\Builder;
use Hyperf\Di\Annotation\Inject;

class ExampleController
{
    /**
     * @Inject()
     * @var CurdInterface
     */
    private CurdInterface $curd;

    public function lists(): array
    {
        $validate = $this->curd->listsValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }
        return $this->curd
            ->listsModel('example')
            ->setSubQuery(function (Builder $query) {
                $query->where('create_time', '>', 1566209600);
            })
            ->result();
    }
}
```

- **setOrder(string $column, string $direction): self**
  -  **column** `string` 排序字段
  -  **direction** `string` 排序方式

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

    public function lists(): array
    {
        $validate = $this->curd->listsValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }
        return $this->curd
            ->listsModel('example')
            ->setOrder('create_time', 'desc')
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

    public function lists(): array
    {
        $validate = $this->curd->listsValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }
        return $this->curd
            ->listsModel('example')
            ->setField(['id', 'name'])
            ->result();
    }
}
```



