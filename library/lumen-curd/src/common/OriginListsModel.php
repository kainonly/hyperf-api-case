<?php

namespace lumen\curd\common;

use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Trait ListsModel
 * @package lumen\curd\common
 * @property string $model
 * @property array $post
 * @property array $origin_lists_validate
 * @property array $origin_lists_default_validate
 * @property array $origin_lists_before_result
 * @property array $origin_lists_condition
 * @property Closure|null $origin_lists_query
 * @property string $origin_lists_order
 * @property string $origin_lists_field
 */
trait OriginListsModel
{
    public function originLists()
    {
        $validator = Validator::make($this->post, array_merge(
            $this->origin_lists_validate,
            $this->origin_lists_default_validate
        ));

        if ($validator->fails()) {
            return [
                'error' => 1,
                'msg' => $validator->errors()
            ];
        }

        if (method_exists($this, '__originListsBeforeHooks') &&
            !$this->__originListsBeforeHooks()) {
            return $this->origin_lists_before_result;
        }

        try {
            $condition = $this->origin_lists_condition;
            if (isset($this->post['where'])) {
                $condition = array_merge(
                    $condition,
                    $this->post['where']
                );
            }

            $listsQuery = DB::table($this->model)
                ->where($condition)
                ->orderBy(...$this->origin_lists_order);

            $lists = empty($this->origin_lists_query) ?
                $listsQuery->get([$this->origin_lists_field]) :
                $listsQuery->where($this->origin_lists_query)
                    ->get([$this->origin_lists_field]);

            return method_exists($this, '__originListsCustomReturn') ?
                $this->__originListsCustomReturn($lists) : [
                    'error' => 0,
                    'data' => $lists
                ];
        } catch (QueryException $e) {
            return [
                'error' => 1,
                'msg' => $e->errorInfo
            ];
        }
    }
}
