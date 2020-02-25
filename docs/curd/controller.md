## CurdController 模型控制器

CurdController 是辅助 CURD 模型库的控制器属性抽象类，通常可以再自定义个抽象类继承它，例如

```php
use Hyperf\Curd\CurdController;

class BaseController extends CurdController
{
    protected HashInterface $hash;
    protected TokenInterface $token;
    protected UtilsInterface $utils;
    protected array $middleware = [];

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
        parent::__construct($container, $request, $response, $validation);
        $this->hash = $hash;
        $this->token = $token;
        $this->utils = $utils;
    }
}
```

#### 公共属性

- **model** `string` 模型名称，默认

```php
protected string $model;
```

- **post** `array` 请求body，默认

```php
protected array $post = [];
```

#### 获取列表数据请求属性

- **origin_lists_validate** `array` 列表数据自定义验证，默认

```php
protected array $origin_lists_validate = [];
```

- **origin_lists_default_validate** `array` 列表数据默认验证，默认

```php
protected array $origin_lists_default_validate = [
    'where' => 'sometimes|array',
    'where.*' => 'array|size:3'
];
```

- **origin_lists_before_result** `array` 默认前置返回结果，默认

```php
protected array $origin_lists_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

- **origin_lists_condition** `array` 列表查询条件，默认

```php
protected array $origin_lists_validate = [];
```

- **origin_lists_query** `Closure|null` 列表查询闭包条件，默认

```php
protected ?Closure $origin_lists_query = null;
```

- **origin_lists_order** `array` 列表数据排序，默认

```php
protected array $origin_lists_order = ['create_time', 'desc'];
```

- **origin_lists_field** `array` 列表数据指定返回字段，默认

```php
protected array $origin_lists_field = ['*'];
```

#### 获取分页数据请求属性

- **lists_validate** `array` 分页自定义验证器，默认

```php
protected array $lists_validate = [];
```

- **lists_default_validate** `array` 分页数据默认验证器，默认

```php
protected array $lists_default_validate = [
    'page' => 'required',
    'page.limit' => 'required|integer|between:1,50',
    'page.index' => 'required|integer|min:1',
    'where' => 'sometimes|array',
    'where.*' => 'array|size:3'
];
```

- **lists_before_result** `array` 分页数据前置返回结果，默认

```php
protected array $lists_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

- **lists_condition** `array` 分页数据查询条件，默认

```php
protected array $lists_condition = [];
```

- **lists_query** `Closure|null` 分页数据查询闭包条件，默认

```php
protected ?Closure $lists_query = null;
```

- **lists_orders** `array` 分页数据排序，默认

```php
protected array $lists_order = ['create_time', 'desc'];
```

- **lists_field** `array` 分页数据限制字段，默认

```php
protected array $lists_field = ['*'];
```

#### 获取单条数据请求属性

- **get_validate** `array` 单条数据自定义验证器，默认

```php
protected array $get_validate = [];
```

- **get_default_validate** `array` 单条数据默认验证器，默认

```php
protected array $get_default_validate = [
    'id' => 'required_without:where|integer',
    'where' => 'required_without:id|array',
    'where.*' => 'array|size:3'
];
```

- **get_before_result** `array` 单条数据前置返回结果，默认

```php
protected array $get_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

- **get_condition** `array` 单条数据查询条件，默认

```php
protected array $get_condition = [];
```

- **get_field** `array` 单条数据限制字段，默认

```php
protected array $get_field = ['*'];
```

#### 新增数据请求属性

- **add_model** `string` 分离新增模型名称，默认

```php
protected string $add_model;
```

- **add_validate** `array` 新增数据自定义验证器，默认

```php
protected array $add_validate = [];
```

- **add_default_validate** `array` 新增数据默认验证器，默认 `[]`

```php
protected array $add_default_validate = [];
```

- **add_auto_timestamp** `bool` 自动更新字段 `create_time` `update_time` 的时间戳，默认

```php
protected bool $add_auto_timestamp = true;
```

- **add_before_result** `array` 新增数据前置返回结果，默认

```php
protected array $add_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

- **add_after_result** `array` 新增数据后置返回结果，默认

```php
protected array $add_after_result = [
    'error' => 1,
    'msg' => 'error:after_fail'
];
```

- **add_fail_result** `array` 新增数据失败返回结果，默认

```php
protected array $add_fail_result = [
    'error' => 1,
    'msg' => 'error:insert_fail'
];
```

#### 修改数据请求属性

- **edit_model** `string` 分离编辑模型名称，默认

```php
protected string $edit_model;
```

- **edit_validate** `array` 编辑自定义验证器，默认

```php
protected array $edit_validate = [];
```

- **edit_default_validate** `array` 编辑默认验证器，默认

```php
protected array $edit_default_validate = [
    'id' => 'required_without:where|integer',
    'switch' => 'required|bool',
    'where' => 'required_without:id|array',
    'where.*' => 'array|size:3'
];
```

- **edit_auto_timestamp** `bool` 自动更新字段 `update_time` 的时间戳，默认

```php
protected bool $edit_auto_timestamp = true;
```

- **edit_switch** `boolean` 是否仅为状态编辑，默认

```php
protected bool $edit_switch = false;
```

- **edit_before_result** `array` 编辑前置返回结果，默认

```php
protected array $edit_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

- **edit_condition** `array` 编辑查询条件，默认

```php
protected array $edit_condition = [];
```

- **edit_fail_result** `array` 编辑失败返回结果，默认

```php
protected array $edit_fail_result = [
    'error' => 1,
    'msg' => 'error:fail'
];
```

- **edit_after_result** `array` 编辑后置返回结果，默认

```php
protected array $edit_after_result = [
    'error' => 1,
    'msg' => 'error:after_fail'
];
```

#### 删除数据请求属性

- **delete_model** `string` 分离删除模型名称，默认

```php
protected string $delete_model;
```

- **delete_validate** `array` 删除自定义验证器，默认

```php
protected array $delete_validate = [];
```

- **delete_default_validate** `array` 删除默认验证器，默认

```php
protected array $delete_default_validate = [
    'id' => 'required_without:where|array',
    'id.*' => 'integer',
    'where' => 'required_without:id|array',
    'where.*' => 'array|size:3'
];
```

- **delete_before_result** `array` 删除前置返回结果，默认

```php
protected array $delete_before_result = [
    'error' => 1,
    'msg' => 'error:before_fail'
];
```

- **delete_condition** `array` 删除查询条件，默认

```php
protected array $delete_condition = [];
```

- **delete_prep_result** `array` 事务开始之后数据写入之前返回结果，默认

```php
protected array $delete_prep_result = [
    'error' => 1,
    'msg' => 'error:prep_fail'
];
```

- **delete_fail_result** `array` 删除失败返回结果，默认

```php
protected array $delete_fail_result = [
    'error' => 1,
    'msg' => 'error:fail'
];
```

- **delete_after_result** `array` 删除后置返回结果，默认

```php
protected array $delete_after_result = [
    'error' => 1,
    'msg' => 'error:after_fail'
];
```