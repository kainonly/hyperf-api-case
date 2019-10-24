<?php

namespace App\Controller;

use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\Curd\CurdController;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;

/**
 * Class Resource
 * @package App\Controller
 * @Controller()
 * @Middlewares({
 *  @Middleware(\App\Middleware\AppAuthVerify::class)
 * })
 */
class Resource extends CurdController
{
    use OriginListsModel;
    protected $model = 'resource';
}