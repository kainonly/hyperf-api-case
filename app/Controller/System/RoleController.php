<?php
declare (strict_types=1);

namespace App\Controller\System;

use App\RedisModel\System\AdminRedis;
use App\RedisModel\System\RoleRedis;
use Hyperf\Curd\Common\AddModel;
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Common\EditModel;
use Hyperf\Curd\Common\GetModel;
use Hyperf\Curd\Common\ListsModel;
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Utils\Context;
use stdClass;

/**
 * Class RoleController
 * @package App\Controller\System
 */
class RoleController extends BaseController
{
    use OriginListsModel, ListsModel, GetModel, AddModel, EditModel, DeleteModel;

    protected static string $model = 'role_mix';
    protected static string $addModel = 'role';
    protected static string $editModel = 'role';
    protected static string $deleteModel = 'role';
    protected static array $addValidate = [
        'name' => 'required|array',
        'key' => 'required',
        'resource' => 'required|array'
    ];
    protected static array $editValidate = [
        'name' => 'required_if:switch,false|array',
        'key' => 'required_if:switch,false',
        'resource' => 'required_if:switch,false|array'
    ];

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

    public function addBeforeHook(stdClass $ctx): bool
    {
        $ctx->body['name'] = json_encode($ctx->body['name'], JSON_UNESCAPED_UNICODE);
        $ctx->resource = $ctx->body['resource'];
        unset($ctx->body['resource']);
        return true;
    }

    public function addAfterHook(stdClass $ctx): bool
    {
        $resource = [];
        foreach ($ctx->resource as $key => $value) {
            $resource[] = [
                'role_key' => $ctx->body['key'],
                'resource_key' => $value
            ];
        }
        $result = Db::table('role_resource_rel')->insert($resource);
        if (!$result) {
            Context::set('error', [
                'error' => 1,
                'msg' => 'insert resource failed'
            ]);
            return false;
        }
        $this->clearRedis();
        return true;
    }

    public function editBeforeHook(stdClass $ctx): bool
    {
        $ctx->resource = [];
        if (!$ctx->switch) {
            $ctx->body['name'] = json_encode($ctx->body['name'], JSON_UNESCAPED_UNICODE);
            $ctx->resource = $ctx->body['resource'];
            unset($ctx->body['resource']);
        }
        return true;
    }

    public function editAfterHook(stdClass $ctx): bool
    {
        if (!$ctx->switch) {
            $resource = [];
            foreach ($ctx->$resource as $key => $value) {
                $resource[] = [
                    'role_key' => $ctx->body['key'],
                    'resource_key' => $value
                ];
            }
            Db::table('role_resource_rel')
                ->where('role_key', '=', $ctx->body['key'])
                ->delete();
            $result = Db::table('role_resource_rel')
                ->insert($resource);
            if (!$result) {
                Context::set('error', [
                    'error' => 1,
                    'msg' => 'insert resource failed'
                ]);
                return false;
            }
        }
        $this->clearRedis();
        return true;
    }

    public function deleteAfterHook(stdClass $ctx): bool
    {
        $this->clearRedis();
        return true;
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

        $exists = Db::table('role')
            ->where('key', '=', $body['key'])
            ->exists();

        return [
            'error' => 0,
            'data' => $exists
        ];
    }
}