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

Router::get('/', [App\Controller\IndexController::class, 'index']);
Router::post('/', [App\Controller\IndexController::class, 'index']);
Router::addGroup('/sys/', function () {
    Router::get('test', function () {
        return [
            'status' => 1
        ];
    });
});
Router::addGroup('/system', function () {
    AutoController(App\Controller\System\TestController::class);
    AutoController(App\Controller\System\MainController::class, [
        'middleware' => [
            App\Middleware\System\AuthVerify::class => [
                'resource', 'information', 'update', 'uploads'
            ]
        ]
    ]);
    AutoController(App\Controller\System\AclController::class, [
        'middleware' => [
            App\Middleware\System\AuthVerify::class,
            App\Middleware\System\RbacVerify::class
        ]
    ]);
    AutoController(App\Controller\System\ResourceController::class, [
        'middleware' => [
            App\Middleware\System\AuthVerify::class,
            App\Middleware\System\RbacVerify::class
        ]
    ]);
    AutoController(App\Controller\System\PolicyController::class, [
        'middleware' => [
            App\Middleware\System\AuthVerify::class,
            App\Middleware\System\RbacVerify::class
        ]
    ]);
    AutoController(App\Controller\System\RoleController::class, [
        'middleware' => [
            App\Middleware\System\AuthVerify::class,
            App\Middleware\System\RbacVerify::class
        ]
    ]);
    AutoController(App\Controller\System\AdminController::class, [
        'middleware' => [
            App\Middleware\System\AuthVerify::class,
            App\Middleware\System\RbacVerify::class
        ]
    ]);
}, [
    'middleware' => [
        Hyperf\Extra\Cors\Cors::class
    ]
]);
