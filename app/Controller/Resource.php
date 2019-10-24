<?php

namespace App\Controller;

use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\Curd\CurdController;
use Hyperf\HttpServer\Annotation\Controller;

/**
 * Class Resource
 * @package App\Controller
 * @Controller()
 */
class Resource extends CurdController
{
    use OriginListsModel;
    protected $model = 'resource';
}