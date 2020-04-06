<?php
declare (strict_types=1);

namespace App\Controller\System;

use App\RedisModel\System\RoleRedis;
use Hyperf\Di\Annotation\Inject;

class PolicyController extends BaseController
{
    /**
     * @Inject()
     * @var RoleRedis
     */
    private RoleRedis $roleRedis;

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
            ->originListsModel('policy')
            ->result();
    }

    public function add(): array
    {
        $validate = $this->curd->addValidation([
            'resource_key' => 'required',
            'acl_key' => 'required',
            'policy' => 'required'
        ]);
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }

        return $this->curd
            ->addModel('policy')
            ->setAutoTimestamp(false)
            ->afterHook(function () {
                $this->clearRedis();
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
            ->deleteModel('policy')
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
    }
}