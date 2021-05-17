<?php
declare(strict_types=1);

namespace App\Controller\System;

use Hyperf\Curd\Common\ListsModel;

class LogsController extends BaseController
{
    use ListsModel;

    protected static string $model = 'logs';
    protected static array $listsOrders = ['time' => 'desc'];
}