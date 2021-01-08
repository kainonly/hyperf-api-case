<?php
declare(strict_types=1);

namespace App\Controller\System;

use Hyperf\DbConnection\Db;

class GalleryController extends BaseController
{
    public function originLists(): array
    {
        $validate = $this->curd->originListsValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }

        return $this->curd
            ->originListsModel('gallery')
            ->setOrder('create_time', 'desc')
            ->result();
    }

    public function lists(): array
    {
        $validate = $this->curd->listsValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }

        return $this->curd
            ->listsModel('gallery')
            ->setOrder('create_time', 'desc')
            ->result();
    }

    public function bulkInsert(): array
    {
        $body = $this->request->post();
        $validator = $this->validation->make($body, [
            'type_id' => 'required',
            'data' => 'required|array',
            'data.*.name' => 'required',
            'data.*.url' => 'required'
        ]);
        if ($validator->fails()) {
            return [
                'error' => 1,
                'msg' => $validator->errors()
            ];
        }
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
        Db::table('gallery')->insert($data);
        return [
            'error' => 0,
            'msg' => 'ok'
        ];
    }

    public function edit(): array
    {
        $validate = $this->curd->editValidation([
            'type_id' => 'required',
            'name' => 'required',
            'url' => 'required',
        ]);
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }
        return $this->curd
            ->editModel('gallery')
            ->result();
    }

    public function delete(): array
    {
        $validate = $this->curd->deleteValidation();
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }

        return $this->curd
            ->deleteModel('gallery')
            ->result();
    }
}