<?php
declare(strict_types=1);

namespace App\Controller\System;

use App\RedisModel\System\AdminRedis;
use Hyperf\Curd\Validation;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Utils\Context;

class AdminController extends BaseController
{
    /**
     * @Inject()
     * @var AdminRedis
     */
    private AdminRedis $adminRedis;

    public function originLists(): array
    {
        $body = $this->curd->should(Validation::ORIGINLISTS);
        return $this->curd
            ->model('admin', $body)
            ->select(['id', 'username', 'role', 'call', 'email', 'phone', 'avatar', 'status'])
            ->originLists();
    }

    public function lists(): array
    {
        $body = $this->curd->should(Validation::LISTS);
        return $this->curd
            ->model('admin', $body)
            ->select(['id', 'username', 'role', 'call', 'email', 'phone', 'avatar', 'status'])
            ->lists();
    }

    public function get(): array
    {
        $body = $this->request->post();
        $validate = $this->curd->getValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }

        $result = $this->curd
            ->getModel('admin', $body)
            ->setField(['id', 'username', 'role', 'call', 'email', 'phone', 'avatar', 'status'])
            ->result();

        $username = Context::get('auth')['user'];
        $data = Db::table('admin_basic')
            ->where('username', '=', $username)
            ->where('status', '=', 1)
            ->first();

        if (!empty($data) && $data->id === (int)$body['id']) {
            $result['data']->self = true;
        }

        return $result;
    }

    public function add(): array
    {
        $body = $this->request->post();
        $validate = $this->curd->addValidation([
            'username' => [
                'required',
                'between:4,20'
            ],
            'password' => [
                'required',
                'between:12,20',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&-+])(?=.*[0-9])[\w|@$!%*?&-+]+$/'
            ],
            'role' => ['required']
        ]);
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }

        $role = $body['role'];
        $body['password'] = $this->hash->create($body['password']);
        unset($body['role']);
        return $this->curd
            ->addModel('admin_basic', $body)
            ->afterHook(function (AddAfterParams $params) use ($role) {
                $data = Db::table('admin_role_rel')->insert([
                    'admin_id' => $params->getId(),
                    'role_key' => $role
                ]);
                if (!$data) {
                    Context::set('error', [
                        'error' => 1,
                        'msg' => 'role assoc wrong'
                    ]);
                    return false;
                }
                $this->clearRedis();
                return true;
            })
            ->result();
    }

    public function edit(): array
    {
        $body = $this->request->post();
        $validate = $this->curd->editValidation([
            'role' => ['required_if:switch,false']
        ]);
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }

        $username = Context::get('auth')['user'];
        $data = Db::table('admin_basic')
            ->where('username', '=', $username)
            ->where('status', '=', 1)
            ->first();
        if (!empty($data) && $data->id === $body['id']) {
            return [
                'error' => 2,
                'msg' => 'Detected as currently logged in user'
            ];
        }
        $role = null;
        if (!$body['switch']) {
            $role = $body['role'];
            unset($body['role']);
            if (!empty($body['password'])) {
                $validator = $this->validation->make($body, [
                    'password' => [
                        'between:12,20',
                        'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&-+])(?=.*[0-9])[\w|@$!%*?&-+]+$/'
                    ],
                ]);

                if ($validator->fails()) {
                    return [
                        'error' => 1,
                        'msg' => $validator->errors()
                    ];
                }
            } else {
                unset($body['password']);
            }
        }

        return $this->curd
            ->editModel('admin_basic', $body)
            ->afterHook(function (EditAfterParams $params) use ($role) {
                if (!$params->isSwitch()) {
                    Db::table('admin_role_rel')
                        ->where('admin_id', '=', $params->getId())
                        ->update([
                            'role_key' => $role
                        ]);
                }
                $this->clearRedis();
                return true;
            })
            ->result();
    }

    public function delete(): array
    {
        $body = $this->request->post();
        $validate = $this->curd->deleteValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }

        $username = Context::get('auth')->user;
        $data = Db::table('admin_basic')
            ->where('username', '=', $username)
            ->where('status', '=', 1)
            ->first();
        if (!empty($data) && in_array($data->id, $body['id'], true)) {
            return [
                'error' => 1,
                'msg' => 'is self'
            ];
        }
        return $this->curd
            ->deleteModel('admin_basic', $body)
            ->afterHook(function () {
                $this->clearRedis();
                return true;
            })
            ->result();
    }

    /**
     * Clear Redis
     */
    private function clearRedis(): void
    {
        $this->adminRedis->clear();
    }

    /**
     * Exists Acl Key
     * @return array
     */
    public function validedUsername(): array
    {
        $body = $this->request->post();
        if (empty($body['username'])) {
            return [
                'error' => 1,
                'msg' => 'require username'
            ];
        }

        $exists = Db::table('admin_basic')
            ->where('username', '=', $body['username'])
            ->exists();

        return [
            'error' => 0,
            'data' => $exists
        ];
    }

}