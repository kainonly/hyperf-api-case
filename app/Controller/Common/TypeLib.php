<?php
declare(strict_types=1);

namespace App\Controller\Common;

use Hyperf\Curd\Common\AddModel;
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Common\EditModel;
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\DbConnection\Db;

trait TypeLib
{
    use OriginListsModel, AddModel, EditModel, DeleteModel;

    public function sort(): array
    {
        $body = $this->curd->should([
            'data' => 'required|array',
            'data.*.id' => 'required',
            'data.*.sort' => 'required'
        ]);
        Db::transaction(function () use ($body) {
            foreach ($body['data'] as $value) {
                Db::table(static::$model)
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