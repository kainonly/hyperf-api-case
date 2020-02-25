## DeleteModel 删除数据

DeleteModel 是针对删除数据的通用请求处理，请求 `body` 可使用 **id** 或 **where** 字段进行查询，二者选一

- **id** `int[]` 主键数组
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

将 **Hyperf\Curd\Common\DeleteModel** 引入，然后定义模型 **model** 的名称（即表名称）

```php
use Hyperf\Curd\Common\DeleteModel;

class AclController extends BaseController
{
    use DeleteModel;
    protected string $model = 'acl';
}
```

#### 验证器

验证器由 `delete_validate`（自定义） 与 `delete_default_validate`（全局默认）属性合并组成；`delete_default_validate` 可以通过重写设置取消默认验证

```php
use Hyperf\Curd\Common\DeleteModel;

class AclController extends BaseController
{
    use DeleteModel;
    protected string $model = 'acl';

    protected array $delete_validate = [
        'sha1' => 'required|string'
    ];
}
```

#### 前置处理周期

发生在验证之后、数据删除之前，则需要继承 **Hyperf\Curd\Lifecycle\DeleteBeforeHooks**

```php
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Lifecycle\DeleteBeforeHooks;

class AclController extends BaseController implements DeleteBeforeHooks
{
    use DeleteModel;
    protected string $model = 'acl';

    /**
     * @inheritDoc
     */
    public function deleteBeforeHooks(): bool
    {
        return true;
    }
}
```

**deleteBeforeHooks** 的返回值为 `false` 则在此结束执行，并返回 **delete_before_result** 属性的值，默认为

```php
protected array $delete_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

可以通过重写 `delete_before_result` 自定义前置返回

```php
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Lifecycle\DeleteBeforeHooks;

class AclController extends BaseController implements DeleteBeforeHooks
{
    use DeleteModel;
    protected string $model = 'acl';

    /**
     * @inheritDoc
     */
    public function deleteBeforeHooks(): bool
    {
        $this->delete_before_result = [
            'error'=> 1,
            'msg'=> 'error:bad'
        ];
        return false;
    }
}
```

#### 事务启动周期

发生在事务启动之后、Query执行之前，则需要继承 **Hyperf\Curd\Lifecycle\DeletePrepHooks**

```php
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Lifecycle\DeletePrepHooks;

class AclController extends BaseController implements DeletePrepHooks
{
    use DeleteModel;
    protected string $model = 'acl';

    /**
     * @inheritDoc
     */
    public function deletePrepHooks(): bool
    {
        return true;
    }
}
```

**deletePrepHooks** 的返回值为 `false` 则在此结束执行进行事务回滚，并返回 **delete_prep_result** 属性的值，默认为：

```php
protected array $delete_prep_result = [
    'error' => 1,
    'msg' => 'error:prep_fail'
];
```

可以通过重写 `delete_prep_result` 自定义返回

```php
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Lifecycle\DeletePrepHooks;

class AclController extends BaseController implements DeletePrepHooks
{
    use DeleteModel;
    protected string $model = 'acl';

    /**
     * @inheritDoc
     */
    public function deletePrepHooks(): bool
    {
        $this->delete_prep_result = [
            'error'=> 1,
            'msg'=> 'error:bad'
        ];
        return false;
    }
}
```

#### 后置处理周期

发生在数据删除成功之后、提交事务之前，则需要继承 **Hyperf\Curd\Lifecycle\DeleteAfterHooks**

```php
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Lifecycle\DeleteAfterHooks;

class AclController extends BaseController implements DeleteAfterHooks
{
    use DeleteModel;
    protected string $model = 'acl';

    /**
     * @inheritDoc
     */
    public function deleteAfterHooks(): bool
    {
        return true;
    }
}
```

**deleteAfterHooks** 的返回值为 `false` 则在此结束执行进行事务回滚，并返回 **delete_after_result** 属性的值，默认为：

```php
protected array $delete_after_result = [
    'error' => 1,
    'msg' => 'error:after_fail'
];
```

可以通过重写 `delete_after_result` 自定义后置返回

```php
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Lifecycle\DeleteAfterHooks;

class AclController extends BaseController implements DeleteAfterHooks
{
    use DeleteModel;
    protected string $model = 'acl';

    /**
     * @inheritDoc
     */
    public function deleteAfterHooks(): bool
    {
        $this->delete_after_result = [
            'error'=> 1,
            'msg'=> 'error:sync_failed'
        ];
        return false;
    }
}
```