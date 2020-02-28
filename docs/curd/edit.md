## EditModel 编辑数据

EditModel 是针对修改数据的通用请求处理，请求 `body` 可使用 **id** 或 **where** 字段进行查询，二者选一

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

将 **Hyperf\Curd\Common\EditModel** 引入，然后定义模型 **model** 的名称（即表名称）

```php
use Hyperf\Curd\Common\EditModel;

class AclController extends BaseController
{
    use EditModel;
    protected string $model = 'acl';
}
```

#### 验证器

验证器由 `edit_validate`（自定义） 与 `edit_default_validate`（全局默认）属性合并组成；`edit_default_validate` 可以通过重写设置取消默认验证

```php
use Hyperf\Curd\Common\EditModel;

class AclController extends BaseController
{
    use EditModel;
    protected string $model = 'acl';

    protected array $edit_validate = [
        'sha1' => 'required|string'
    ];
}
```

#### 前置处理周期

发生在验证之后、数据写入之前，则需要继承 **Hyperf\Curd\Lifecycle\EditBeforeHooks**

```php
use Hyperf\Curd\Common\EditModel;
use Hyperf\Curd\Lifecycle\EditBeforeHooks;

class AclController extends BaseController implements EditBeforeHooks
{
    use EditModel;
    protected string $model = 'acl';

    /**
     * @inheritDoc
     */
    public function editBeforeHooks(): bool
    {
        if (!$this->edit_switch) {
            // 如果不属于状态编辑
        }
        return true;
    }
}
```

**editBeforeHooks** 的返回值为 `false` 则在此结束执行，并返回 **edit_before_result** 属性的值，默认为

```php
protected array $edit_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

可以通过重写 `edit_before_result` 自定义前置返回

```php
use Hyperf\Curd\Common\EditModel;
use Hyperf\Curd\Lifecycle\EditBeforeHooks;

class AclController extends BaseController implements EditBeforeHooks
{
    use EditModel;
    protected string $model = 'acl';

    /**
     * @inheritDoc
     */
    public function editBeforeHooks(): bool
    {
        $this->edit_before_result = [
            'error'=> 1,
            'msg'=> 'error:bad'
        ];
        return false;
    }
}
```

#### 后置处理周期

发生在写入成功之后、提交事务之前，则需要继承 **Hyperf\Curd\Lifecycle\EditAfterHooks**

```php
use Hyperf\Curd\Common\EditModel;
use Hyperf\Curd\Lifecycle\EditAfterHooks;

class AclController extends BaseController implements EditAfterHooks
{
    use EditModel;
    protected string $model = 'acl';

    /**
     * @inheritDoc
     */
    public function editAfterHooks(): bool
    {
        if (!$this->edit_switch) {
            // 如果不属于状态编辑
        }
        return true;
    }
}
```

**editAfterHooks** 的返回值为 `false` 则在此结束执行进行事务回滚，并返回 **edit_after_result** 属性的值，默认为：

```php
protected array $edit_after_result = [
    'error' => 1,
    'msg' => 'error:after_fail'
];
```

可以通过重写 `edit_after_result` 自定义后置返回

```php
use Hyperf\Curd\Common\EditModel;
use Hyperf\Curd\Lifecycle\EditAfterHooks;

class AclController extends BaseController implements EditAfterHooks
{
    use EditModel;
    protected string $model = 'acl';

    /**
     * @inheritDoc
     */
    public function editAfterHooks(): bool
    {
        $this->edit_after_result = [
            'error'=> 1,
            'msg'=> 'error:sync_failed'
        ];
        return false;
    }
}
```