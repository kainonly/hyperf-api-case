<?php
declare(strict_types=1);

namespace App\Controller\System;

use Exception;
use Hyperf\Support\Func\Auth;
use Psr\Http\Message\ResponseInterface;
use App\RedisModel\System\AdminRedis;

class MainController extends BaseController
{
    use Auth;

    /**
     * User login
     * @return ResponseInterface
     * @throws Exception
     */
    public function login(): ResponseInterface
    {
        $this->post = $this->request->post();
        $validator = $this->validation->make($this->post, [
            'username' => 'required|between:4,20',
            'password' => 'required|between:8,18',
        ]);

        if ($validator->fails()) {
            throw new Exception(join(',', $validator->errors()->all()));
        }

        $data = AdminRedis::create($this->container)
            ->get($this->post['username']);

        if (empty($data)) {
            throw new Exception('error:username_not_exists');
        }

        if (!$this->hash->check($this->post['password'], $data['password'])) {
            throw new Exception('error:password_incorrect');
        }

        return $this->create('system', [
            'user' => $data['username'],
            'role' => explode(',', $data['role'])
        ]);
    }

    /**
     * User verify
     * @return ResponseInterface
     * @throws Exception
     */
    public function verify(): ResponseInterface
    {
        $this->post = $this->request->post();
        return $this->authVerify('system');
    }

    /**
     * User logout
     * @return ResponseInterface
     * @throws Exception
     */
    public function logout(): ResponseInterface
    {
        $this->post = $this->request->post();
        return $this->destory('system');
    }

    /**
     * @return array
     */
    public function resource(): array
    {
        $this->post = $this->request->post();
        return [];
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