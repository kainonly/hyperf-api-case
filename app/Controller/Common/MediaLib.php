<?php
declare(strict_types=1);

namespace App\Controller\Common;

use App\Service\CosService;
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Common\EditModel;
use Hyperf\Curd\Common\ListsModel;
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use stdClass;

trait MediaLib
{
    use OriginListsModel, ListsModel, EditModel, DeleteModel;

    /**
     * @Inject()
     * @var CosService
     */
    private CosService $cos;

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
        Db::table(static::$model)->insert($data);
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
                Db::table(static::$model)
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
        $ctx->objects = Db::table(static::$model)
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
        $response = $this->cos->delete($ctx->objects);
        return $response->getStatusCode() === 200;
    }

    public function count(): array
    {
        $total = Db::table(static::$model)->count();
        $values = Db::table(static::$model)
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