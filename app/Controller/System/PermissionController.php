<?php
declare(strict_types=1);

namespace App\Controller\System;

use Hyperf\Curd\Common\AddModel;
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Common\EditModel;
use Hyperf\Curd\Common\GetModel;
use Hyperf\Curd\Common\ListsModel;
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\DbConnection\Db;
use stdClass;

class PermissionController extends BaseController
{
    use OriginListsModel, ListsModel, GetModel, AddModel, EditModel, DeleteModel;

    protected static string $model = 'permission';
    protected static array $addValidate = [
        'name' => 'required|array',
        'key' => 'required',
    ];
    protected static array $editValidate = [
        'name' => 'required_if:switch,false|array',
        'key' => 'required_if:switch,false',
    ];

    public function addBeforeHook(stdClass $ctx): bool
    {
        $this->before($ctx->body);
        return true;
    }

    public function editBeforeHook(stdClass $ctx): bool
    {
        if (!$ctx->switch) {
            $this->before($ctx->body);
        }
        return true;
    }

    private function before(array &$body): void
    {
        $body['name'] = json_encode($body['name'], JSON_UNESCAPED_UNICODE);
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

        $exists = Db::table('permission')
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