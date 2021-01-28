<?php
declare(strict_types=1);

namespace App\Controller\System;

use Hyperf\DbConnection\Db;

class VideoTypeController extends BaseController
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
            ->originListsModel('video_type')
            ->setOrder('sort', 'asc')
            ->result();
    }

    public function add(): array
    {
        $validate = $this->curd->addValidation([
            'name' => 'required',
        ]);
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }
        return $this->curd
            ->addModel('video_type')
            ->result();
    }

    public function edit(): array
    {
        $validate = $this->curd->editValidation([
            'name' => 'required',
        ]);
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }
        return $this->curd
            ->editModel('video_type')
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
            ->deleteModel('video_type')
            ->result();
    }

    public function sort(): array
    {
        $body = $this->request->post();
        $validate = $this->validation->make($body, [
            'data' => 'required|array',
            'data.*.id' => 'required',
            'data.*.sort' => 'required'
        ]);
        if ($validate->fails()) {
            return [
                'error' => 1,
                'msg' => $validate->errors()
            ];
        }
        Db::transaction(function () use ($body) {
            foreach ($body['data'] as $value) {
                Db::table('video_type')
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