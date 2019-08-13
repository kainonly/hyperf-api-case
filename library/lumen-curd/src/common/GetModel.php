<?php

namespace lumen\curd\common;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Trait GetModel
 * @package lumen\curd\common
 * @property string model
 * @property array post
 * @property array get_validate
 * @property array get_default_validate
 * @property array get_before_result
 * @property array get_condition
 * @property array get_columns
 */
trait GetModel
{
    public function get()
    {
        $validator = Validator::make($this->post, array_merge(
            $this->get_validate,
            $this->get_default_validate
        ));

        if ($validator->fails()) {
            return [
                'error' => 1,
                'msg' => $validator->errors()
            ];
        }

        if (method_exists($this, '__getBeforeHooks') &&
            !$this->__getBeforeHooks()) {
            return $this->get_before_result;
        }

        try {
            $condition = $this->get_condition;
            if (isset($this->post['id'])) {
                array_push(
                    $condition,
                    ['id', '=', $this->post['id']]
                );
            } else {
                $condition = array_merge(
                    $condition,
                    $this->post['where']
                );
            }

            $data = DB::table($this->model)
                ->where($condition)
                ->first($this->get_columns);

            return method_exists($this, '__getCustomReturn') ?
                $this->__getCustomReturn($data) : [
                    'error' => 0,
                    'data' => $data
                ];
        } catch (QueryException $e) {
            return [
                'error' => 1,
                'msg' => $e->errorInfo
            ];
        }
    }
}
