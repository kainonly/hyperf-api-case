<?php
declare(strict_types=1);

namespace App\Controller\System;

use App\RedisModel\System\AclRedis;
use App\RedisModel\System\RoleRedis;
use Hyperf\Curd\Common\AddModel;
use Hyperf\Curd\Common\GetModel;
use Hyperf\Curd\Common\ListsModel;
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\Curd\Lifecycle\AddAfterHook;
use Hyperf\Curd\Lifecycle\AddBeforeHook;
use Hyperf\Curd\Validation;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use stdClass;

class AclController extends BaseController implements AddBeforeHook, AddAfterHook
{
    use OriginListsModel, ListsModel, GetModel, AddModel;

    protected static string $model = 'acl';
    protected static array $addValidate = [
        'name' => 'required|array',
        'key' => 'required',
        'write' => 'sometimes|array',
        'read' => 'sometimes|array'
    ];

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

    public function addBeforeHook(array &$body): bool
    {
        $this->before($body);
        return true;
    }

    public function addAfterHook(array &$body, stdClass $param): bool
    {
        $this->clearRedis();
        return true;
    }

    public function edit(): array
    {
        $body = $this->curd->should(Validation::EDIT, [
            'name' => 'required_if:switch,false|array',
            'key' => 'required_if:switch,false',
            'write' => 'sometimes|array',
            'read' => 'sometimes|array'
        ]);
        if (!$body['switch']) {
            $this->before($body);
        }
        return $this->curd
            ->model('acl', $body)
            ->afterHook(function () {
                $this->clearRedis();
                return true;
            })
            ->edit();
    }

    private function before(array &$body): void
    {
        $body['name'] = json_encode($body['name'], JSON_UNESCAPED_UNICODE);
        $body['write'] = implode(',', (array)$body['write']);
        $body['read'] = implode(',', (array)$body['read']);
    }

    public function delete(): array
    {
        $body = $this->curd->should(Validation::DELETE);
        return $this->curd
            ->model('acl', $body)
            ->afterHook(function () {
                $this->clearRedis();
                return true;
            })
            ->delete();
    }

    private function clearRedis(): void
    {
        $this->aclRedis->clear();
        $this->roleRedis->clear();
    }

    /**
     * Exists Acl Name
     * @return array
     */
    public function validedName(): array
    {
        $body = $this->request->post();
        if (empty($body['name'])) {
            return [
                'error' => 1,
                'msg' => 'require name'
            ];
        }

        $exists = Db::table('acl')
            ->where('name->zh_cn', '=', $body['name'])
            ->exists();

        return [
            'error' => 0,
            'data' => $exists
        ];
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
                'msg' => 'require key'
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
