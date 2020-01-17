<?php
declare(strict_types=1);

namespace App\Controller\System;

use Exception;
use Hyperf\Support\Traits\Auth;
use Psr\Http\Message\ResponseInterface;
use App\RedisModel\System\AdminRedis;

class MainController extends BaseController
{
    use Auth;

    /**
     * User login
     * @return ResponseInterface
     */
    public function login(): ResponseInterface
    {
        try {
            $validator = $this->validation->make($this->post, [
                'username' => 'required|between:4,20',
                'password' => 'required|between:8,18',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->errors());
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
        } catch (Exception $e) {
            return $this->response->json([
                'error' => 1,
                'msg' => $e->getMessage()
            ]);
        }
    }

    /**
     * User verify
     * @return ResponseInterface
     */
    public function verify(): ResponseInterface
    {
        try {
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
     * @return ResponseInterface
     */
    public function logout(): ResponseInterface
    {
        try {
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
        return [];
    }

    /**
     * @return array
     */
    public function information(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function update(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function uploads(): array
    {
        return [];
    }
}