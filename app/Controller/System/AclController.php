<?php
declare(strict_types=1);

namespace App\Controller\System;

use App\RedisModel\System\AclRedis;
use App\RedisModel\System\RoleRedis;
use Hyperf\Curd\Common\AddModel;
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Common\EditModel;
use Hyperf\Curd\Common\GetModel;
use Hyperf\Curd\Common\ListsModel;
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use stdClass;

class AclController extends BaseController
{
    use OriginListsModel, ListsModel, GetModel, AddModel, EditModel, DeleteModel;

    protected static string $model = 'acl';
    protected static array $addValidate = [
        'name' => 'required|array',
        'key' => 'required',
        'write' => 'sometimes|array',
        'read' => 'sometimes|array'
    ];
    protected static array $editValidate = [
        'name' => 'required_if:switch,false|array',
        'key' => 'required_if:switch,false',
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

    public function addBeforeHook(stdClass $ctx): bool
    {
        $this->before($ctx->body);
        return true;
    }

    public function addAfterHook(stdClass $ctx): bool
    {
        $this->clearRedis();
        return true;
    }

    public function editBeforeHook(stdClass $ctx): bool
    {
        if (!$ctx->switch) {
            $this->before($ctx->body);
        }
        return true;
    }

    public function editAfterHook(stdClass $ctx): bool
    {
        $this->clearRedis();
        return true;
    }

    private function before(array &$body): void
    {
        $body['name'] = json_encode($body['name'], JSON_UNESCAPED_UNICODE);
        $body['write'] = implode(',', (array)$body['write']);
        $body['read'] = implode(',', (array)$body['read']);
    }

    public function deleteAfterHook(stdClass $ctx): bool
    {
        $this->clearRedis();
        return true;
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
                'msg' => 'require key'
            ];
        }

        $exists = Db::table('acl')
            ->where('key', '=', $body['key'])
            ->exists();

        return [
            'error' => 0,
            'data' => [
                'exists' => $exists
            ]
        ];
    }
}
