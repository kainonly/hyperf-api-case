## Auth 登录鉴权

Auth 创建登录后将 Token 字符串存储在Cookie 中，使用它需要引用该特性与部分依赖，以 `app/Controller/System/MainController.php` 为例

```php
class MainController extends BaseController
{
    use Auth;
    /**
     * @Inject()
     * @var RefreshToken
     */
    private RefreshToken $refreshToken;
    /**
     * @Inject()
     * @var AdminRedis
     */
    private AdminRedis $adminRedis;

    /**
     * User login
     */
    public function login(): ResponseInterface
    {
        try {
            $this->post = $this->request->post();
            $validator = $this->validation->make($this->post, [
                'username' => 'required|between:4,20',
                'password' => 'required|between:8,18',
            ]);

            if ($validator->fails()) {
                return $this->response->json([
                    'error' => 1,
                    'msg' => $validator->errors()
                ]);
            }

            $data = $this->adminRedis->get($this->post['username']);

            if (empty($data)) {
                throw new RuntimeException('username not exists');
            }

            if (!$this->hash->check($this->post['password'], $data['password'])) {
                throw new RuntimeException('password incorrect');
            }
            $symbol = new stdClass();
            $symbol->user = $data['username'];
            $symbol->role = explode(',', $data['role']);
            return $this->create('system', $symbol);
        } catch (Exception $e) {
            return $this->response->json([
                'error' => 1,
                'msg' => $e->getMessage()
            ]);
        }
    }

    /**
     * User verify
     */
    public function verify(): ResponseInterface
    {
        try {
            $this->post = $this->request->post();
            return $this->authVerify('system');
        } catch (Exception $e) {
            return $this->response->json([
                'error' => 1,
                'msg' => $e->getMessage()
            ]);
        }
    }

    /**
     * User logout
     */
    public function logout(): ResponseInterface
    {
        try {
            $this->post = $this->request->post();
            return $this->destory('system');
        } catch (Exception $e) {
            return $this->response->json([
                'error' => 1,
                'msg' => $e->getMessage()
            ]);
        }
    }
}
```

#### refreshTokenExpires(): int

设置令牌自动刷新的总时效，通过重写自定义

- **Return** `int` 默认 `604800`，单位< 秒 >

#### create(string $scene, ?stdClass $symbol): Psr\Http\Message\ResponseInterface

创建登录鉴权

- **scene** `string` 场景标签
- **symbol** `array` 标识
- **Return** `Psr\Http\Message\ResponseInterface`

#### authVerify($scene): Psr\Http\Message\ResponseInterface

验证登录

- **scene** `string` 场景标签

#### destory(string $scene): Psr\Http\Message\ResponseInterface

销毁登录鉴权

- **scene** `string` 场景标签
- **Return** `Psr\Http\Message\ResponseInterface`