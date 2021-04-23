<?php
declare(strict_types=1);

namespace App\Controller\System;

use App\Controller\Common\TypeLib;

class PictureTypeController extends BaseController
{
    use TypeLib;

    protected static string $model = 'picture_type';
    protected static array $originListsOrders = [
        'sort' => 'asc'
    ];
    protected static array $addValidate = [
        'name' => 'required'
    ];
    protected static array $editValidate = [
        'name' => 'required'
    ];
}