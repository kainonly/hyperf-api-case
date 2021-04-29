<?php
declare(strict_types=1);

namespace App\Controller\System;

use Exception;
use Hyperf\Curd\Common\EditModel;
use Hyperf\Curd\Common\GetModel;
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\DbConnection\Db;

class ColumnController extends BaseController
{
    use OriginListsModel, GetModel, EditModel;

    protected static string $model = 'column';
    protected static array $originListsOrders = [
        'sort'
    ];

    /**
     * 更新数据表字段
     * @return array
     * @throws Exception
     */
    public function update(): array
    {
        $body = $this->curd->should([
            'schema' => 'required',
            'columns' => 'array',
            'columns.*.column' => 'required',
            'columns.*.datatype' => 'required',
            'columns.*.name' => 'required|array',
        ]);
        return Db::transaction(function () use ($body) {
            $now = time();
            $data = [];
            foreach ($body['columns'] as $value) {
                $data[] = [
                    'schema' => $body['schema'],
                    'column' => $value['column'],
                    'datatype' => $value['datatype'],
                    'name' => json_encode($value['name'], JSON_UNESCAPED_UNICODE),
                    'description' => json_encode((object)$value['description'], JSON_UNESCAPED_UNICODE),
                    'sort' => $value['sort'],
                    'extra' => json_encode((object)$value['extra']),
                    'create_time' => $now,
                    'update_time' => $now
                ];
            }
            Db::table('column')
                ->where('schema', '=', $body['schema'])
                ->delete();
            return Db::table('column')->insert($data) > 0;
        }) ? [
            'error' => 0,
            'msg' => 'ok'
        ] : [
            'error' => 1,
            'msg' => 'failed'
        ];
    }
}