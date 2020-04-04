<?php
declare(strict_types=1);

namespace App\Controller\System;

use App\RedisModel\System\AclRedis;
use App\RedisModel\System\RoleRedis;
use Hyperf\Curd\Common\AddAfterParams;
use Hyperf\Curd\Common\DeleteAfterParams;
use Hyperf\Curd\Common\EditAfterParams;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;

class AclController extends BaseController
{
    /**
     * @Inject()
     * @var AclRedis
     */
    private AclRedis $aclRedis;
    /**
     * @Inject()
     * @var RoleRedis
     */
    private RoleRedis $roleRedis;

    public function originLists(): array
    {
        $validate = $this->curd->originListsValidation([]);
        if ($validate['error'] === 1) {
            return $validate;
        }
        return $this->curd
            ->originListsModel('acl')
            ->setOrder('create_time', 'desc')
            ->result();
    }

    public function lists(): array
    {
        $validate = $this->curd->listsValidation([]);
        if ($validate['error'] === 1) {
            return $validate;
        }
        return $this->curd
            ->listsModel('acl')
            ->setOrder('create_time', 'desc')
            ->result();
    }

    public function get(): array
    {
        $validate = $this->curd->getValidation([]);
        if ($validate['error'] === 1) {
            return $validate;
        }
        return $this->curd
            ->getModel('acl')
            ->result();
    }

    public function add(): array
    {
        $validate = $this->curd->addValidation([
            'key' => 'required',
            'name' => 'required|json'
        ]);
        if ($validate['error'] === 1) {
            return $validate;
        }

        return $this->curd
            ->addModel('acl')
            ->afterHook(function (AddAfterParams $params) {
                $this->clearRedis();
                return true;
            })
            ->result();
    }

    public function edit(): array
    {
        $validate = $this->curd->editValidation([
            'key' => 'required',
            'name' => 'required|json'
        ]);
        if ($validate['error'] === 1) {
            return $validate;
        }

        return $this->curd
            ->editModel('acl')
            ->afterHook(function (EditAfterParams $params) {
                $this->clearRedis();
                return true;
            })
            ->result();
    }

    public function delete(): array
    {
        $validate = $this->curd->deleteValidation([]);
        if ($validate['error'] === 1) {
            return $validate;
        }

        return $this->curd
            ->deleteModel('acl')
            ->afterHook(function (DeleteAfterParams $params) {
                $this->clearRedis();
                return true;
            })
            ->result();
    }

    private function clearRedis(): void
    {
        $this->aclRedis->clear();
        $this->roleRedis->clear();
    }

    /**
     * Exists Acl Key
     * @return array
     */
    public function validedKey(): array
    {
        $body = $this->request->post();
        if (empty($body['key'])) {
            return [
                'error' => 1,
                'msg' => 'error:require_key'
            ];
        }

        $exists = Db::table('acl')
            ->where('key', '=', $body['key'])
            ->exists();

        return [
            'error' => 0,
            'data' => $exists
        ];
    }
}
