## Delete 删除数据

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

    public function delete(): array
    {
        // <<预处理>>

        $validate = $this->curd->deleteValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }

        // <<前置处理>>

        return $this->curd
            ->deleteModel('example')
            ->result();
    }
}
```

#### deleteValidation(array $validate = [], ?array $default = null): ValidatorInterface

验证编辑数据的请求 `body`

- **validate** `array` 自定义验证，作为默认验证的填充
- **default** `array` 默认验证，默认值为空

```php
[
    'id' => 'required_without:where|array',
    'id.*' => 'integer',
    'where' => 'required_without:id|array',
    'where.*' => 'array|size:3'
]
```

请求 `body` 可使用 **id** 或 **where** 字段进行查询，二者选一

- **id** `array` 主键
- **where** `array` 查询条件，必须使用数组查询方式来定义

#### deleteModel(string $name, ?array $body = null): DeleteModel

生成删除数据的模型处理

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

    public function delete(): array
    {
        $body = $this->request->post();
        $validate = $this->curd->deleteValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }
        unset($body['where']);
        return $this->curd
            ->deleteModel('example', $body)
            ->result();
    }
}
```

#### DeleteModel 模型类

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

    public function delete(): array
    {
        $validate = $this->curd->deleteValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }
        return $this->curd
            ->deleteModel('example')
            ->setCondition([
                ['enterprise', '=', 10001]
            ])
            ->result();
    }
}
```

- **prepHook(Closure $value): self**
  - **value** `Closure`

事务预处理

```php
use Hyperf\Curd\Common\DeletePrepParams;
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

    public function delete(): array
    {
        $body = $this->request->post();
        $validate = $this->curd->deleteValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }
        return $this->curd
            ->deleteModel('example', $body)
            ->prepHook(function (DeletePrepParams $params) {
                $ids = $params->getId();
                $body = $params->getBody();
                return true;
                // <删除之前>
            })
            ->result();
    }
}
```

- **afterHook(Closure $value): self**
  - **value** `Closure`

在删除数据事务中增加后置处理，例如

```php
use Hyperf\Curd\Common\DeleteAfterParams;
use Hyperf\Curd\CurdInterface;
use Hyperf\DbConnection\Db;
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

    public function delete(): array
    {
        $body = $this->request->post();
        $validate = $this->curd->deleteValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }
        return $this->curd
            ->deleteModel('example', $body)
            ->afterHook(function (DeleteAfterParams $params) {
                // <删除之后>
                Db::table('example_sub')
                    ->where('eid', '=', $params->getId()[0])
                    ->delete();
                return true;
            })
            ->result();
    }
}
```