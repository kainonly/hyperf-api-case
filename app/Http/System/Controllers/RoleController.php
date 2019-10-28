<?php

namespace App\Http\System\Controllers;

use lumen\curd\common\GetModel;
use lumen\curd\common\ListsModel;
use lumen\curd\common\OriginListsModel;

class RoleController extends BaseController
{
    use GetModel, OriginListsModel, ListsModel;
    protected $model = 'role';
}
