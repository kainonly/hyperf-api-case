<?php
declare(strict_types=1);

namespace App\Controller\System;

use Hyperf\Curd\Common\AddModel;
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Common\EditModel;
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\DbConnection\Db;

class PictureTypeController extends BaseController
{
    use OriginListsModel, AddModel, EditModel, DeleteModel;

    protected static string $model = 'picture_type';
    protected static array $originListsOrders = [
        'sort' => 'asc'
    ];
    protected static array $addValidate = [
        'name' => 'required'
    ];
    protected static array $editValidate = [
        'name' => 'required'
    ];

    public function sort(): array
    {
        $body = $this->curd->should([
            'data' => 'required|array',
            'data.*.id' => 'required',
            'data.*.sort' => 'required'
        ]);
        Db::transaction(function () use ($body) {
            foreach ($body['data'] as $value) {
                Db::table('picture_type')
                    ->where('id', '=', $value['id'])
                    ->update(['sort' => $value['sort']]);
            }
        });
        return [
            'error' => 0,
            'msg' => 'ok'
        ];
    }
}