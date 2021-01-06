<?php
declare(strict_types=1);

namespace App\Controller\System;

class GalleryTypeController extends BaseController
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
            ->originListsModel('gallery_type')
            ->setOrder('create_time', 'desc')
            ->result();
    }

    public function add(): array
    {
        $validate = $this->curd->addValidation([
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
            ->addModel('gallery_type')
            ->result();
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
            ->editModel('gallery_type')
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
            ->deleteModel('gallery_type')
            ->result();
    }
}