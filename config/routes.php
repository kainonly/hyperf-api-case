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
    $options = [
        'middleware' => [
            App\Middleware\System\AuthVerify::class,
            App\Middleware\System\RbacVerify::class
        ]
    ];
    AutoController(App\Controller\System\AclController::class, $options);
    AutoController(App\Controller\System\ResourceController::class, $options);
    AutoController(App\Controller\System\PolicyController::class, $options);
    AutoController(App\Controller\System\PermissionController::class, $options);
    AutoController(App\Controller\System\RoleController::class, $options);
    AutoController(App\Controller\System\AdminController::class, $options);
    AutoController(App\Controller\System\PictureController::class, $options);
    AutoController(App\Controller\System\PictureTypeController::class, $options);
    AutoController(App\Controller\System\VideoController::class, $options);
    AutoController(App\Controller\System\VideoTypeController::class, $options);
}, [
    'middleware' => [
        Hyperf\Extra\Cors\CorsMiddleware::class
    ]
]);
