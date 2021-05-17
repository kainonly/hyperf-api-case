<?php
declare(strict_types=1);

namespace App\Controller\System;

use Hyperf\Curd\Common\ListsModel;

class ActivitiesController extends BaseController
{
    use ListsModel;

    protected static string $model = 'activities';
    protected static array $listsOrders = ['time' => 'desc'];
}