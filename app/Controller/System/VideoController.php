<?php
declare(strict_types=1);

namespace App\Controller\System;

use App\Client\CosClient;
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Common\EditModel;
use Hyperf\Curd\Common\ListsModel;
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use stdClass;

class VideoController extends BaseController
{
    use OriginListsModel, ListsModel, EditModel, DeleteModel;

    protected static string $model = 'video';

    /**
     * @Inject()
     * @var CosClient
     */
    private CosClient $cosClient;

    public function bulkAdd(): array
    {
        $body = $this->curd->should([
            'type_id' => 'required',
            'data' => 'required|array',
            'data.*.name' => 'required',
            'data.*.url' => 'required'
        ]);
        $data = [];
        $now = time();
        foreach ($body['data'] as $value) {
            $data[] = [
                'type_id' => $body['type_id'],
                'name' => $value['name'],
                'url' => $value['url'],
                'create_time' => $now,
                'update_time' => $now
            ];
        }
        Db::table('video')->insert($data);
        return [
            'error' => 0,
            'msg' => 'ok'
        ];
    }

    public function bulkEdit(): array
    {
        $body = $this->curd->should([
            'type_id' => 'required',
            'ids' => 'required|array',
        ]);
        Db::transaction(function () use ($body) {
            foreach ($body['ids'] as $value) {
                Db::table('video')
                    ->where('id', '=', $value)
                    ->update(['type_id' => $body['type_id']]);
            }
        });
        return [
            'error' => 0,
            'msg' => 'ok'
        ];
    }

    public function deleteBeforeHook(stdClass $ctx): bool
    {
        $ctx->objects = Db::table('video')
            ->whereIn('id', $ctx->body['id'])
            ->get()
            ->map(fn($v) => [
                'Key' => $v->url
            ])
            ->toArray();
        return true;
    }

    public function deleteAfterHook(stdClass $ctx): bool
    {
        $response = $this->cosClient->delete($ctx->objects);
        return $response->getStatusCode() === 200;
    }

    public function count(): array
    {
        $total = Db::table('video')->count();
        $values = Db::table('video')
            ->groupBy(['type_id'])
            ->get(['type_id', Db::raw('count(*) as size')]);

        return [
            'error' => 0,
            'data' => [
                'total' => $total,
                'values' => $values
            ]
        ];
    }
}