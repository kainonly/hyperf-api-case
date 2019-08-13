<?php

namespace lumen\curd\common;

use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Trait ListsModel
 * @package lumen\curd\common
 * @property string model
 * @property array post
 * @property array lists_validate
 * @property array lists_default_validate
 * @property array lists_before_result
 * @property array lists_condition
 * @property Closure lists_condition_group
 * @property string lists_order_columns
 * @property string lists_order_direct
 * @property array lists_columns
 */
trait ListsModel
{
    public function lists()
    {
        $validator = Validator::make($this->post, array_merge(
            $this->lists_validate,
            $this->lists_default_validate
        ));

        if ($validator->fails()) {
            return [
                'error' => 1,
                'msg' => $validator->errors()
            ];
        }

        if (method_exists($this, '__listsBeforeHooks') &&
            !$this->__listsBeforeHooks()) {
            return $this->lists_before_result;
        }

        try {
            $condition = $this->lists_condition;
            if (isset($this->post['where'])) {
                $condition = array_merge(
                    $condition,
                    $this->post['where']
                );
            }

            $totalQuery = DB::table($this->model)
                ->where($condition);

            $total = empty($this->lists_condition_group) ?
                $totalQuery->count() :
                $totalQuery->where($this->lists_condition_group)
                    ->count();

            $listsQuery = DB::table($this->model)
                ->where($condition)
                ->orderBy($this->lists_order_columns, $this->lists_order_direct)
                ->take($this->post['page']['limit'])
                ->skip($this->post['page']['index'] - 1);

            $lists = empty($this->lists_condition_group) ?
                $listsQuery->get($this->lists_columns) :
                $listsQuery->where($this->lists_condition_group)
                    ->get($this->lists_columns);

            return method_exists($this, '__listsCustomReturn') ?
                $this->__listsCustomReturn($lists, $total) : [
                    'error' => 0,
                    'data' => [
                        'lists' => $lists,
                        'total' => $total
                    ]
                ];
        } catch (QueryException $e) {
            return [
                'error' => 1,
                'msg' => $e->errorInfo
            ];
        }
    }
}
