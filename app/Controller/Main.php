<?php

namespace App\Controller;

use Hyperf\DbConnection\Db;
use Hyperf\HttpServer\Annotation\Controller;
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
            $raws = Db::table('admin')
                ->where('username', '=', $this->post['username'])
                ->where('status', '=', 1)
                ->first();

            if (empty((array)$raws)) {
                return [
                    'error' => 1,
                    'msg' => 'username not exists'
                ];
            }

            if (!$this->hash->check($this->post['password'], $raws->password)) {
                return [
                    'error' => 1,
                    'msg' => 'password'
                ];
            }

            return $this->__create('default', [
                'username' => $raws->username,
                'role' => $raws->role
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
        return $this->__verify('default');
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     * @PostMapping(path="logout")
     */
    public function logout()
    {
        return $this->__destory('default');
    }
}