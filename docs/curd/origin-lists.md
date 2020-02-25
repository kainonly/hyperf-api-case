## OriginListsModel 获取列表数据

OriginListsModel 是针对列表数据的通用请求处理，请求 `body` 使用数组查询方式来定义

- **where** `array` 查询条件

!> 请求中的 **where** 还会与 **origin_lists_condition** 合并条件

**where** 必须使用数组查询方式来定义，例如

```json
{
    "where":[
        ["name", "=", "kain"]
    ]
}
```

如果条件中包含模糊查询

```json
{
    "where":[
        ["name", "like", "%v%"]
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

将 **Hyperf\Curd\Common\OriginListsModel** 引入，然后定义模型 **model** 的名称（即表名称）

```php
use Hyperf\Curd\Common\OriginListsModel;

class AclController extends BaseController
{
    use OriginListsModel;
    protected string $model = 'acl';
}
```

#### 验证器

验证器由 `origin_lists_validate`（自定义） 与 `origin_lists_default_validate`（全局默认）属性合并组成；`origin_lists_default_validate` 通常为 `[]` 用于特殊场景，例如：每个接口需验证企业标识、团队标识等。

```php
use Hyperf\Curd\Common\OriginListsModel;

class AclController extends BaseController
{
    use OriginListsModel;
    protected string $model = 'acl';
    protected array $origin_lists_default_validate = [];
    protected array $origin_lists_validate = [
        'status' => 'required|integer'
    ];
}
```

#### 前置处理周期

如自定义前置处理，则需要继承 **Hyperf\Curd\Lifecycle\OriginListsBeforeHooks**

```php
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\Curd\Lifecycle\OriginListsBeforeHooks;

class AclController extends BaseController implements OriginListsBeforeHooks
{
    use OriginListsModel;
    protected string $model = 'acl';

    /**
     * @inheritDoc
     */
    public function originListsBeforeHooks(): bool
    {
        return true;
    }
}
```

**originListsBeforeHooks** 的返回值为 `false` 则在此结束执行，并返回 **origin_lists_before_result** 属性的值，默认为

```php
protected array $origin_lists_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

可以通过重写 `origin_lists_before_result` 自定义前置返回

```php
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\Curd\Lifecycle\OriginListsBeforeHooks;

class AclController extends BaseController implements OriginListsBeforeHooks
{
    use OriginListsModel;
    protected string $model = 'acl';

    /**
     * @inheritDoc
     */
    public function originListsBeforeHooks(): bool
    {
        $this->origin_lists_before_result = [
            'error'=> 1,
            'msg'=> 'error:bad'
        ];
        return false;
    }
}
```

#### 固定条件

如需要给接口在后端就设定固定条件，只需要重写 **origin_lists_condition**，默认为

```php
protected array $origin_lists_condition = [];
```

例如，加入限制状态过滤

```php
use Hyperf\Curd\Common\OriginListsModel;

class AclController extends BaseController
{
    use OriginListsModel;
    protected string $model = 'acl';
    protected array $origin_lists_condition = [
        ['status', '=', 1]
    ];
}
```

如果接口的查询条件较为特殊，可以重写 **origin_lists_query**

```php
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\Database\Query\Builder;

class AclController extends BaseController
{
    use OriginListsModel;
    protected string $model = 'acl';

    public function __construct(
        ContainerInterface $container,
        RequestInterface $request,
        ResponseInterface $response,
        ValidatorFactoryInterface $validation,
        HashInterface $hash,
        TokenInterface $token,
        UtilsInterface $utils
    )
    {
        parent::__construct($container, $request, $response, $validation, $hash, $token, $utils);
        $this->origin_lists_query = function (Builder $query) {
            $query->where('status', '=', 1);
        };
    }
}
```

#### 列表排序

如果需要列表按条件排序，只需要重写 **origin_lists_orders**，默认为

```php
protected array $origin_lists_order = ['create_time', 'desc'];
```

#### 指定返回字段

如需要给接口限制返回字段，只需要重写 **origin_lists_field**，默认为

```php
protected array $origin_lists_field = ['*'];
```

例如，仅返回 `id` `name` `key` 字段

```php
use Hyperf\Curd\Common\OriginListsModel;

class AclController extends BaseController
{
    use OriginListsModel;
    protected string $model = 'acl';
    protected array $origin_lists_field = ['id', 'name', 'key'];
}
```

#### 自定义返回结果

如自定义返回结果，则需要继承 **Hyperf\Curd\Lifecycle\OriginListsCustom**

```php
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\Curd\Lifecycle\OriginListsCustom;

class AclController extends BaseController implements OriginListsCustom
{
    use OriginListsModel;
    protected string $model = 'acl';

    /**
     * @inheritDoc
     */
    public function originListsCustomReturn(array $lists): array
    {
        return [
            'error' => 0,
            'data' => $lists
        ];
    }
}
```