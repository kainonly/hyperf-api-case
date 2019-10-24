<?php

namespace App\Controller;

use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\Middlewares;

/**
 * Class Acl
 * @package App\Controller
 * @Controller()
 * @Middlewares({
 *  @Middleware(\App\Middleware\AppAuthVerify::class)
 * })
 */
class Acl extends Base
{
    use OriginListsModel;
    protected $model = 'acl';
}
