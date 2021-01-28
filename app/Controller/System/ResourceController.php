<?php
declare(strict_types=1);

namespace App\Controller\System;

use App\RedisModel\System\ResourceRedis;
use App\RedisModel\System\RoleRedis;
use Hyperf\Curd\Common\AddModel;
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Common\EditModel;
use Hyperf\Curd\Common\GetModel;
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Utils\Context;
use stdClass;

class ResourceController extends BaseController
{
    use OriginListsModel, GetModel, AddModel, EditModel, DeleteModel;

    protected static string $model = 'resource';
    protected static array $originListsOrders = [
        'sort' => 'asc'
    ];
    protected static array $addValidate = [
        'key' => 'required',
        'name' => 'required|array'
    ];
    protected static array $editValidate = [
        'key' => 'required_if:switch,false',
        'name' => 'required_if:switch,false|array'
    ];

    /**
     * @Inject()
     * @var ResourceRedis
     */
    private ResourceRedis $resourceRedis;
    /**
     * @Inject()
     * @var RoleRedis
     */
    private RoleRedis $roleRedis;

    public function addBeforeHook(stdClass $ctx): bool
    {
        $ctx->body['name'] = json_encode($ctx->body['name'], JSON_UNESCAPED_UNICODE);
        return true;
    }

    public function addAfterHook(stdClass $ctx): bool
    {
        $this->clearRedis();
        return true;
    }

    public function editBeforeHook(stdClass $ctx): bool
    {
        $ctx->body['name'] = json_encode($ctx->body['name'], JSON_UNESCAPED_UNICODE);
        $data = Db::table('resource')
            ->where('id', '=', $ctx->body['id'])
            ->first();

        if (!empty($data)) {
            $ctx->key = $data->key;
        }
        return true;
    }

    public function editAfterHook(stdClass $ctx): bool
    {
        if (!empty($ctx->key)) {
            Db::table('resource')
                ->where('parent', '=', $ctx->key)
                ->update([
                    'parent' => $ctx->body['key']
                ]);
        }
        $this->clearRedis();
        return true;
    }

    public function deleteBeforeHook(stdClass $ctx): bool
    {
        $data = Db::table('resource')
            ->whereIn('id', $ctx->body['id'])
            ->first();
        if (empty($data)) {
            Context::set('error', [
                'error' => 1,
                'msg' => 'not exist'
            ]);
            return false;
        }
        $exists = Db::table('resource')
            ->where('parent', '=', $data->key)
            ->exists();
        if ($exists) {
            Context::set('error', [
                'error' => 1,
                'msg' => 'not exist'
            ]);
            return false;
        }
        return true;
    }

    public function deleteAfterHook(stdClass $ctx): bool
    {
        $this->clearRedis();
        return true;
    }

    /**
     * Sort Lists
     * @return array
     */
    public function sort(): array
    {
        $body = $this->curd->should([
            'data' => 'required|array',
        ]);
        return Db::transaction(function () use ($body) {
            foreach ($body['data'] as $value) {
                Db::table('resource')
                    ->where('id', '=', $value['id'])
                    ->update([
                        'sort' => $value['sort']
                    ]);
            }
            $this->clearRedis();
            return true;
        }) ? [
            'error' => 0,
            'msg' => 'success'
        ] : [
            'error' => 1,
            'msg' => 'error'
        ];
    }

    private function clearRedis(): void
    {
        $this->resourceRedis->clear();
        $this->roleRedis->clear();
    }

    /**
     * Exists Resources Key
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