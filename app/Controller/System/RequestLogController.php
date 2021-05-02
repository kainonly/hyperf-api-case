<?php
declare(strict_types=1);

namespace App\Controller\System;

use Hyperf\Curd\Common\ListsModel;

class RequestLogController extends BaseController
{
    use ListsModel;

    protected static string $model = 'request_log';
    protected static array $listsOrders = ['time' => 'desc'];
}