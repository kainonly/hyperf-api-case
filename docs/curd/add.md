## AddModel 新增数据

AddModel 是针对新增数据的通用请求处理

#### 初始化

将 **Hyperf\Curd\Common\AddModel** 引入，然后定义模型 **model** 的名称（即表名称）

```php
use Hyperf\Curd\Common\AddModel;

class AclController extends BaseController
{
    use AddModel;
    protected string $model = 'acl';
}
```

#### 验证器

验证器由 `add_validate`（自定义） 与 `add_default_validate`（全局默认）属性合并组成；`add_default_validate` 通常为 `[]` 用于特殊场景，例如：每个接口需验证企业标识、团队标识等。

```php
use Hyperf\Curd\Common\AddModel;

class AclController extends BaseController
{
    use AddModel;
    protected string $model = 'acl';
    protected array $add_default_validate = [];
    protected array $add_validate = [
        'key' => 'required|string',
        'name' => 'required|json'
    ];
}
```

#### 前置处理周期

发生在验证之后、数据写入之前，则需要继承 **Hyperf\Curd\Lifecycle\AddBeforeHooks**

```php
use Hyperf\Curd\Common\AddModel;
use Hyperf\Curd\Lifecycle\AddBeforeHooks;

class AclController extends BaseController implements AddBeforeHooks
{
    use AddModel;
    protected string $model = 'acl';

    /**
    * @inheritDoc
    */
    public function addBeforeHooks(): bool
    {
        return true;
    }
}
```

**addBeforeHooks** 的返回值为 `false` 则在此结束执行，并返回 **add_before_result** 属性的值，默认为：

```php
protected array $add_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

可以通过重写 **add_before_result** 自定义前置返回

```php
use Hyperf\Curd\Common\AddModel;
use Hyperf\Curd\Lifecycle\AddBeforeHooks;

class AclController extends BaseController implements AddBeforeHooks
{
    use AddModel;
    protected string $model = 'acl';

    /**
    * @inheritDoc
    */
    public function addBeforeHooks(): bool
    {
        $this->add_before_result = [
            'error'=> 1,
            'msg'=> 'error:bad'
        ];
        return false;
    }
}
```

#### 后置处理周期

发生在写入成功之后、提交事务之前，则需要继承 **Hyperf\Curd\Lifecycle\AddAfterHooks**

```php
use Hyperf\Curd\Common\AddModel;
use Hyperf\Curd\Lifecycle\AddAfterHooks;

class AclController extends BaseController implements AddAfterHooks
{
    use AddModel;
    protected string $model = 'acl';

    /**
    * @inheritDoc
    */
    public function addAfterHooks(int $id): bool
    {
        return true;
    }
}
```

**id** 为模型写入后返回的主键，**addAfterHooks** 的返回值为 `false` 则在此结束执行进行事务回滚，并返回 **add_after_result** 属性的值，默认为：

```php
protected $add_after_result = [
    'error' => 1,
    'msg' => 'error:after_fail'
];
```

可以通过重写 **add_after_result** 自定义后置返回

```php
use Hyperf\Curd\Common\AddModel;
use Hyperf\Curd\Lifecycle\AddAfterHooks;

class AclController extends BaseController implements AddAfterHooks
{
    use AddModel;
    protected string $model = 'acl';

    /**
    * @inheritDoc
    */
    public function addAfterHooks(int $id): bool
    {
        $this->add_after_result = [
            'error'=> 1,
            'msg'=> 'error:sync_failed'
        ];
        return false;
    }
}
```