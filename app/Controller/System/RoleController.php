<?php
declare (strict_types=1);

namespace App\Controller\System;

use App\RedisModel\System\AdminRedis;
use App\RedisModel\System\RoleRedis;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Utils\Context;

/**
 * Class RoleController
 * @package App\Controller\System
 */
class RoleController extends BaseController
{
    /**
     * @Inject()
     * @var RoleRedis
     */
    private RoleRedis $roleRedis;
    /**
     * @Inject()
     * @var AdminRedis
     */
    private AdminRedis $adminRedis;

    public function originLists(): array
    {
        $validate = $this->curd->originListsValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }

        return $this->curd
            ->originListsModel('role')
            ->setOrder('create_time', 'desc')
            ->result();
    }

    public function lists(): array
    {
        $validate = $this->curd->listsValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }

        return $this->curd
            ->listsModel('role')
            ->setOrder('create_time', 'desc')
            ->result();
    }

    public function get(): array
    {
        $validate = $this->curd->getValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }

        return $this->curd
            ->getModel('role')
            ->result();
    }

    public function add(): array
    {
        $body = $this->request->post();
        $validate = $this->curd->addValidation([
            'name' => 'required',
            'key' => 'required',
            'resource' => 'required|array'
        ]);
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }

        $resource = $body['resource'];
        unset($body['resource']);
        return $this->curd
            ->addModel('role_basic', $body)
            ->afterHook(function () use ($body, $resource) {
                $resourceLists = [];
                foreach ($resource as $key => $value) {
                    $resourceLists[] = [
                        'role_key' => $body['key'],
                        'resource_key' => $value
                    ];
                }
                $result = Db::table('role_resource')
                    ->insert($resourceLists);
                if (!$result) {
                    Context::set('error', [
                        'error' => 1,
                        'msg' => 'insert resource failed'
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
            'name' => 'required',
            'key' => 'required',
            'resource' => 'required|array'
        ]);
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }

        $resource = null;
        if (!$body['switch']) {
            $resource = $body['resource'];
            unset($body['resource']);
        }
        return $this->curd
            ->editModel('role_basic', $body)
            ->afterHook(static function () use ($body, $resource) {
                $resourceLists = [];
                foreach ($resource as $key => $value) {
                    $resourceLists[] = [
                        'role_key' => $body['key'],
                        'resource_key' => $value
                    ];
                }
                Db::table('role_resource')
                    ->where('role_key', '=', $body['key'])
                    ->delete();
                $result = Db::table('role_resource')
                    ->insert($resourceLists);
                if (!$result) {
                    Context::set('error', [
                        'error' => 1,
                        'msg' => 'insert resource failed'
                    ]);
                    return false;
                }
                return true;
            })
            ->result();
    }

    public function delete(): array
    {
        $validate = $this->curd->deleteValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }

        return $this->curd
            ->deleteModel('role_basic')
            ->afterHook(function () {
                $this->clearRedis();
                return true;
            })
            ->result();
    }

    /**
     * Clear Cache
     */
    private function clearRedis(): void
    {
        $this->roleRedis->clear();
        $this->adminRedis->clear();
    }

    /**
     * Exists Role Key
     * @return array
     */
    public function validedKey(): array
    {
        $body = $this->request->post();
        if (empty($body['key'])) {
            return [
                'error' => 1,
                'msg' => 'require key'
            ];
        }

        $exists = Db::table('resource')
            ->where('key', '=', $body['key'])
            ->exists();

        return [
            'error' => 0,
            'data' => $exists
        ];
    }
}