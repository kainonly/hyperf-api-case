<?php

namespace App\Http\System\Controllers;

use Lumen\Curd\Common\GetModel;
use Lumen\Curd\Common\ListsModel;
use Lumen\Curd\Common\OriginListsModel;

class RoleController extends BaseController
{
    use GetModel, OriginListsModel, ListsModel;
    protected $model = 'role';
}
