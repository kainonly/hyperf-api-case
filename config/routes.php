<?php

declare(strict_types=1);

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

use Hyperf\HttpServer\Router\Router;

Router::get('/', [\App\Controller\IndexController::class, 'index']);
Router::addGroup('/system', function () {
    AutoController(\App\Controller\System\MainController::class);
    AutoController(\App\Controller\System\AclController::class);
    AutoController(\App\Controller\System\ResourceController::class);
    AutoController(\App\Controller\System\PolicyController::class);
    AutoController(\App\Controller\System\RoleController::class);
    AutoController(\App\Controller\System\AdminController::class);
}, [
    'middleware' => [
        \Hyperf\Extra\Cors\Cors::class
    ]
]);