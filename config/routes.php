<?php
declare(strict_types=1);

use Hyperf\HttpServer\Router\Router;

Router::get('/', [App\Controller\IndexController::class, 'index']);
Router::post('/', [App\Controller\IndexController::class, 'index']);
Router::addGroup('/system', function () {
    AutoController(App\Controller\System\MainController::class, [
        'middleware' => [
            App\Middleware\System\AuthVerify::class => [
                'resource', 'information', 'update', 'uploads', 'cosPresigned'
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
    AutoController(App\Controller\System\GalleryTypeController::class, [
        'middleware' => [
            App\Middleware\System\AuthVerify::class,
            App\Middleware\System\RbacVerify::class
        ]
    ]);
    AutoController(App\Controller\System\GalleryController::class, [
        'middleware' => [
            App\Middleware\System\AuthVerify::class,
            App\Middleware\System\RbacVerify::class
        ]
    ]);
}, [
    'middleware' => [
        Hyperf\Extra\Cors\CorsMiddleware::class
    ]
]);
