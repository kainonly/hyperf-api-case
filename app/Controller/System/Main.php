<?php

namespace App\Controller\System;

use App\RedisModel\SystemAdmin;
use Hyperf\Support\Traits\Auth;

class Main extends Base
{
    use Auth;

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

            $data = SystemAdmin::create($this->container)
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

            return $this->__create('system', [
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

    public function verify()
    {
        return $this->__verify('system');
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function logout()
    {
        return $this->__destory('system');
    }
}