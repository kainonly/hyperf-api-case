<?php
declare(strict_types=1);

namespace App\Controller\System;

use Exception;
use App\RedisModel\System\ResourceRedis;
use App\RedisModel\System\RoleRedis;
use Hyperf\Support\Func\Auth;
use Hyperf\Utils\Arr;
use Psr\Http\Message\ResponseInterface;
use App\RedisModel\System\AdminRedis;
use RuntimeException;

class MainController extends BaseController
{
    use Auth;

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

            $data = AdminRedis::create($this->container)
                ->get($this->post['username']);

            if (empty($data)) {
                throw new RuntimeException('username not exists');
            }

            if (!$this->hash->check($this->post['password'], $data['password'])) {
                throw new RuntimeException('password incorrect');
            }

            return $this->create('system', [
                'user' => $data['username'],
                'role' => explode(',', $data['role'])
            ]);
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

    /**
     * @return array
     */
    public function resource(): array
    {
        $this->post = $this->request->post();
        $router = ResourceRedis::create($this->container)->get();
        $role = [];
        foreach (['*'] as $hasRoleKey) {
            $resource = RoleRedis::create($this->container)->get($hasRoleKey, 'resource');
            array_push($role, ...$resource);
        }
        $routerRole = array_unique($role);
        $lists = Arr::where($router, static function ($value) use ($routerRole) {
            $data = (array)$value;
            return in_array($data['key'], $routerRole, true);
        });
        return [
            'error' => 0,
            'data' => array_values($lists)
        ];
    }

    /**
     * @return array
     */
    public function information(): array
    {
        $this->post = $this->request->post();
        return [];
    }

    /**
     * @return array
     */
    public function update(): array
    {
        $this->post = $this->request->post();
        return [];
    }

    /**
     * @return array
     */
    public function uploads(): array
    {
        $this->post = $this->request->post();
        return [];
    }
}