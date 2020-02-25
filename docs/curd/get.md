## GetModel 获取单个数据

GetModel 是针对获取单条数据的通用请求处理，请求 `body` 可使用 **id** 或 **where** 字段进行查询，二者选一

- **id** `int|string` 主键
- **where** `array` 查询条件

**where** 必须使用数组查询方式来定义，例如

```json
{
    "where":[
        ["name", "=", "van"]
    ]
}
```

如果查询条件为 JSON 

```json
{
    "where":[
        ["extra->nickname", "=", "kain"]
    ]
}
```

#### 初始化

将 **Hyperf\Curd\Common\GetModel** 引入，然后定义模型 **model** 的名称（即表名称）

```php
use Hyperf\Curd\Common\GetModel;

class AclController extends BaseController
{
    use GetModel;
    protected string $model = 'acl';
}
```

#### 验证器

验证器由 `get_validate`（自定义） 与 `get_default_validate`（全局默认）属性合并组成；`get_default_validate` 可以通过重写设置取消默认验证

```php
use Hyperf\Curd\Common\GetModel;

class AclController extends BaseController
{
    use GetModel;
    protected string $model = 'acl';

    protected array $get_default_validate = [
        'team' => 'required|string'
    ];
}
```

#### 前置处理周期

如自定义前置处理，则需要继承 **Hyperf\Curd\Lifecycle\GetBeforeHooks**

```php
use Hyperf\Curd\Common\GetModel;
use Hyperf\Curd\Lifecycle\GetBeforeHooks;

class AclController extends BaseController implements GetBeforeHooks
{
    use GetModel;
    protected string $model = 'acl';

    /**
     * @inheritDoc
     */
    public function getBeforeHooks(): bool
    {
        return true;
    }
}
```

**getBeforeHooks** 的返回值为 `false` 则在此结束执行，并返回 **get_before_result** 属性的值，默认为：

```php
protected array $get_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

可以通过重写 `get_before_result` 自定义前置返回

```php
use Hyperf\Curd\Common\GetModel;
use Hyperf\Curd\Lifecycle\GetBeforeHooks;

class AclController extends BaseController implements GetBeforeHooks
{
    use GetModel;
    protected string $model = 'acl';

    /**
     * @inheritDoc
     */
    public function getBeforeHooks(): bool
    {
        $this->get_before_result = [
            'error'=> 1,
            'msg'=> 'error:bad'
        ];        
        return false;
    }
}
```

#### 固定条件

如需要给接口在后端就设定固定条件，只需要重写 **get_condition**，默认为

```php
protected array $get_condition = [];
```

例如，加入企业外键限制

```php
use Hyperf\Curd\Common\GetModel;

class AclController extends BaseController
{
    use GetModel;
    protected string $model = 'acl';
    protected array $get_condition = [
        ['enterprise', '=', 10001]
    ];
}
```

#### 指定返回字段

如需要给接口指定返回字段，只需要重写 **get_field** 默认为

```php
protected array $get_field = ['*'];
```

例如，仅返回 `id` `name` `key` 字段

```php
use Hyperf\Curd\Common\GetModel;

class AclController extends BaseController
{
    use GetModel;
    protected string $model = 'acl';
    protected array $get_field = ['id', 'name', 'key'];
}
```

#### 自定义返回结果

如自定义返回结果，则需要继承 **Hyperf\Curd\Lifecycle\GetCustom**

```php
use think\bit\common\GetModel;
use think\bit\lifecycle\GetCustom;

class AdminClass extends Base implements GetCustom {
    use GetModel;

    protected $model = 'admin';

    public function __getCustomReturn($data)
    {
        return json([
            'error' => 0,
            'data' => $data
        ]);
    }
}

use Hyperf\Curd\Common\GetModel;
use Hyperf\Curd\Lifecycle\GetCustom;

class AclController extends BaseController implements GetCustom
{
    use GetModel;
    protected string $model = 'acl';

    /**
     * @inheritDoc
     */
    public function getCustomReturn(array $data): array
    {
        return [
            'error' => 0,
            'data' => $data
        ];
    }
}
```