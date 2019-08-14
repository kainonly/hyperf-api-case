<?php

namespace lumen\curd\common;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Trait DeleteModel
 * @package lumen\curd\common
 * @property string $model
 * @property array $post
 * @property array $delete_validate
 * @property array $delete_default_validate
 * @property array $delete_before_result
 * @property array $delete_prep_result
 * @property array $delete_condition
 * @property array $delete_after_result
 * @property array $delete_fail_result
 */
trait DeleteModel
{
    public function delete()
    {
        $validator = Validator::make($this->post, array_merge(
            $this->delete_validate,
            $this->delete_default_validate
        ));

        if ($validator->fails()) {
            return [
                'error' => 1,
                'msg' => $validator->errors()
            ];
        }

        if (method_exists($this, '__deleteBeforeHooks') &&
            !$this->__deleteBeforeHooks()) {
            return $this->delete_before_result;
        }


        return !DB::transaction(function () {
            if (method_exists($this, '__deletePrepHooks') &&
                !$this->__deletePrepHooks()) {
                $this->delete_fail_result = $this->delete_prep_result;
                return false;
            }

            $condition = $this->delete_condition;
            if (isset($this->post['id'])) {
                $result = DB::table($this->model)
                    ->whereIn('id', $this->post['id'])
                    ->where($condition)
                    ->delete();
            } else {
                $result = DB::table($this->model)
                    ->where($this->post['where'])
                    ->where($condition)
                    ->delete();
            }

            if (!$result) {
                DB::rollBack();
                return false;
            }

            if (method_exists($this, '__deleteAfterHooks') &&
                !$this->__deleteAfterHooks()) {
                $this->delete_fail_result = $this->delete_after_result;
                DB::rollBack();
                return false;
            }

            return true;
        }) ? $this->delete_fail_result : [
            'error' => 0,
            'msg' => 'ok'
        ];
    }
}
