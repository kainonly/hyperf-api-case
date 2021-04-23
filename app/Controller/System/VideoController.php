<?php
declare(strict_types=1);

namespace App\Controller\System;

use App\Client\CosClient;
use App\Controller\Common\MediaLib;
use Hyperf\Curd\Common\DeleteModel;
use Hyperf\Curd\Common\EditModel;
use Hyperf\Curd\Common\ListsModel;
use Hyperf\Curd\Common\OriginListsModel;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use stdClass;

class VideoController extends BaseController
{
    use MediaLib;

    protected static string $model = 'video';
}