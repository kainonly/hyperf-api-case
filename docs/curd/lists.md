## ListsModel 获取分页数据

ListsModel 是针对分页数据的通用请求处理，请求 `body` 使用数组查询方式来定义

- **where** `array` 查询条件

!> 请求中的 **where** 还会与 **lists_condition** 合并条件

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

将 **Hyperf\Curd\Common\ListsModel** 引入，然后定义模型 **model** 的名称（即表名称）

```php
use Hyperf\Curd\Common\ListsModel;

class AclController extends BaseController
{
    use ListsModel;
    protected string $model = 'acl';
}
```

#### 验证器

验证器由 `lists_validate`（自定义） 与 `lists_default_validate`（全局默认）属性合并组成

```php
use Hyperf\Curd\Common\ListsModel;

class AclController extends BaseController
{
    use ListsModel;
    protected string $model = 'acl';
    protected array $lists_validate = [
        'status' => 'required|integer'
    ];
}
```

#### 前置处理周期

如自定义前置处理，则需要继承 **Hyperf\Curd\Lifecycle\ListsBeforeHooks**

```php
use Hyperf\Curd\Common\ListsModel;
use Hyperf\Curd\Lifecycle\ListsBeforeHooks;

class AclController extends BaseController implements ListsBeforeHooks
{
    use ListsModel;
    protected string $model = 'acl';

    /**
     * @inheritDoc
     */
    public function listsBeforeHooks(): bool
    {
        return true;
    }
}
```

**lListsBeforeHooks** 的返回值为 `false` 则在此结束执行，并返回 **lists_before_result** 属性的值，默认为

```php
protected array $lists_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

可以通过重写 `lists_before_result` 自定义前置返回

```php
use Hyperf\Curd\Common\ListsModel;
use Hyperf\Curd\Lifecycle\ListsBeforeHooks;

class AclController extends BaseController implements ListsBeforeHooks
{
    use ListsModel;
    protected string $model = 'acl';

    /**
     * @inheritDoc
     */
    public function listsBeforeHooks(): bool
    {
        $this->lists_before_result = [
            'error'=> 1,
            'msg'=> 'error:bad'
        ];
        return false;
    }
}
```

#### 固定条件

如需要给接口在后端就设定固定条件，只需要重写 **lists_condition**，默认为

```php
protected array $lists_condition = [];
```

例如，加入限制状态过滤

```php
use Hyperf\Curd\Common\ListsModel;

class AclController extends BaseController
{
    use ListsModel;
    protected string $model = 'acl';
    protected array $lists_condition = [
        ['status', '=', 1]
    ];
}
```

如果接口的查询条件较为特殊，可以重写 **lists_query**

```php
use Hyperf\Curd\Common\ListsModel;
use Hyperf\Database\Query\Builder;

class AclController extends BaseController
{
    use ListsModel;
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
        $this->lists_query = function (Builder $query) {
            $query->where('status', '=', 1);
        };
    }
}
```

#### 列表排序

如果需要列表按条件排序，只需要重写 **lists_orders**，默认为

```php
protected array $lists_order = ['create_time', 'desc'];
```

#### 指定返回字段

如需要给接口限制返回字段，只需要重写 **lists_field**，默认为

```php
protected array $lists_field = ['*'];
```

例如，仅返回 `id` `name` `key` 字段

```php
use Hyperf\Curd\Common\ListsModel;

class AclController extends BaseController
{
    use ListsModel;
    protected string $model = 'acl';
    protected array $lists_field = ['id', 'name', 'key'];
}
```

#### 自定义返回结果

如自定义返回结果，则需要继承 **Hyperf\Curd\Lifecycle\ListsCustom**

```php
use Hyperf\Curd\Common\ListsModel;
use Hyperf\Curd\Lifecycle\ListsCustom;

class AclController extends BaseController implements ListsCustom
{
    use ListsModel;
    protected string $model = 'acl';

    /**
     * @inheritDoc
     */
    public function listsCustomReturn(array $lists, int $total): array
    {
        return [
            'error' => 0,
            'data' => [
                'lists' => $lists,
                'total' => $total
            ]
        ];
    }
}
```