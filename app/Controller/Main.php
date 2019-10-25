<?php

namespace App\Controller;

use App\RedisModel\Admin;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\Support\Traits\Auth;

/**
 * Class Main
 * @package App\Controller
 * @Controller()
 */
class Main extends Base
{
    use Auth;

    /**
     * @PostMapping(path="login")
     */
    public function login()
    {
        try {
            $validator = $this->validation->make($this->post, [
                'username' => 'required|between:4,20',
                'password' => 'required|between:8,18',
            ]);

            if ($validator->fails()) {
                return [
                    'error' => 1,
                    'msg' => $validator->errors()
                ];
            }

            $data = Admin::create($this->container)
                ->get($this->post['username']);

            if (empty($data)) {
                return [
                    'error' => 1,
                    'msg' => 'error:username_not_exists'
                ];
            }

            if (!$this->hash->check($this->post['password'], $data['password'])) {
                return [
                    'error' => 1,
                    'msg' => 'error:password_incorrect'
                ];
            }

            return $this->__create('app', [
                'user' => $data['username'],
                'role' => explode(',', $data['role'])
            ]);
        } catch (\Exception $e) {
            return [
                'error' => 1,
                'msg' => $e->getMessage()
            ];
        }
    }

    /**
     * @PostMapping(path="verify")
     */
    public function verify()
    {
        return $this->__verify('app');
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     * @PostMapping(path="logout")
     * @Middleware(\App\Middleware\AppAuthVerify::class)
     */
    public function logout()
    {
        return $this->__destory('app');
    }
}