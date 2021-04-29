<?php
declare(strict_types=1);

namespace App\Controller\System;

use App\Controller\Common\MediaLib;

class VideoController extends BaseController
{
    use MediaLib;

    protected static string $model = 'video';
}