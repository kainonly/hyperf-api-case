<?php

namespace lumen\curd\common;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Trait EditModel
 * @package lumen\curd\common
 * @property string model
 * @property array post
 * @property boolean edit_switch
 * @property array edit_validate
 * @property array edit_default_validate
 * @property array edit_before_result
 * @property array edit_condition
 * @property array edit_after_result
 * @property array edit_fail_result
 */
trait EditModel
{
    public function edit()
    {
        $default_validator = Validator::make(
            $this->post,
            $this->edit_default_validate
        );

        if ($default_validator->fails()) {
            return [
                'error' => 1,
                'msg' => $default_validator->errors()
            ];
        }

        $this->edit_switch = $this->post['switch'];
        if (!$this->edit_switch) {
            $validator = Validator::make($this->post, $this->edit_validate);
            if ($validator->fails()) {
                return [
                    'error' => 1,
                    'msg' => $validator->errors()
                ];
            }
        }

        unset($this->post['switch']);
        $this->post['update_time'] = time();

        if (method_exists($this, '__editBeforeHooks') &&
            !$this->__editBeforeHooks()) {
            return $this->edit_before_result;
        }

        return !DB::transaction(function () {
            $condition = $this->edit_condition;
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

            unset($this->post['where']);
            $result = DB::table($this->model)
                ->where($condition)
                ->update($this->post);

            if (!$result) {
                return false;
            }

            if (method_exists($this, '__editAfterHooks') &&
                !$this->__editAfterHooks()) {
                $this->edit_fail_result = $this->edit_after_result;
                DB::rollBack();
                return false;
            }

            return true;
        }) ? $this->edit_fail_result : [
            'error' => 0,
            'msg' => 'ok'
        ];
    }
}
