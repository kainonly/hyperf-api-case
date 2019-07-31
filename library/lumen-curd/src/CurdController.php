<?php

namespace lumen\curd;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

abstract class CurdController extends BaseController
{
    protected $model;
    protected $post = [];
    protected $request;

    protected $origin_lists_validate = [];
    protected $origin_lists_default_validate = [
        'where' => 'sometimes|array',
        'where.*' => 'array|size:3'
    ];
    protected $origin_lists_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];
    protected $origin_lists_condition = [];
    protected $origin_lists_condition_group = null;
    protected $origin_lists_order_columns = 'create_time';
    protected $origin_lists_order_direct = 'desc';
    protected $origin_lists_columns = ['*'];

    protected $lists_validate = [];
    protected $lists_default_validate = [
        'page' => 'required',
        'page.limit' => 'required|integer|between:1,50',
        'page.index' => 'required|integer|min:1',
        'where' => 'sometimes|array',
        'where.*' => 'array|size:3'
    ];
    protected $lists_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];
    protected $lists_condition = [];
    protected $lists_condition_group = null;
    protected $lists_order_columns = 'create_time';
    protected $lists_order_direct = 'desc';
    protected $lists_columns = ['*'];

    protected $get_validate = [];
    protected $get_default_validate = [
        'id' => 'required_without:where|integer',
        'where' => 'required_without:id|array',
        'where.*' => 'array|size:3'
    ];
    protected $get_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];
    protected $get_condition = [];
    protected $get_columns = ['*'];

    protected $add_validate = [];
    protected $add_default_validate = [
        'id' => 'sometimes|required|integer'
    ];
    protected $add_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];
    protected $add_after_result = [
        'error' => 1,
        'msg' => 'error:after_fail'
    ];
    protected $add_fail_result = [
        'error' => 1,
        'msg' => 'error:insert_fail'
    ];

    protected $edit_validate = [];
    protected $edit_default_validate = [
        'id' => 'required_without:where|integer',
        'switch' => 'required|bool',
        'where' => 'required_without:id|array',
        'where.*' => 'array|size:3'
    ];
    protected $edit_switch = false;
    protected $edit_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];
    protected $edit_condition = [];
    protected $edit_fail_result = [
        'error' => 1,
        'msg' => 'error:fail'
    ];
    protected $edit_after_result = [
        'error' => 1,
        'msg' => 'error:after_fail'
    ];

    protected $delete_validate = [];
    protected $delete_default_validate = [
        'id' => 'required_without:where|array',
        'id.*' => 'integer',
        'where' => 'required_without:id|array',
        'where.*' => 'array|size:3'
    ];
    protected $delete_before_result = [
        'error' => 1,
        'msg' => 'error:before_fail'
    ];
    protected $delete_condition = [];
    protected $delete_prep_result = [
        'error' => 1,
        'msg' => 'error:prep_fail'
    ];
    protected $delete_fail_result = [
        'error' => 1,
        'msg' => 'error:fail'
    ];
    protected $delete_after_result = [
        'error' => 1,
        'msg' => 'error:after_fail'
    ];

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->post = $request->toArray();
    }
}
