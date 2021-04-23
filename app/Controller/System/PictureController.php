<?php
declare(strict_types=1);

namespace App\Controller\System;

use App\Controller\Common\MediaLib;

class PictureController extends BaseController
{
    use MediaLib;

    protected static string $model = 'picture';
}