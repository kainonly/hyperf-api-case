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
use \Hyperf\Curd\RouterMap;

Router::get('/', function () {
    return [
        'version' => 1
    ];
});

Router::addGroup('/system', function () {
    $options = [
        'middleware' => [
            \App\Middleware\SystemAuthVerify::class
        ]
    ];

    Router::addGroup('/main', function () {
        Router::post('/login', \App\Controller\System\Main::class . '@login');
        Router::post('/verify', \App\Controller\System\Main::class . '@verify');
        Router::post('/logout', \App\Controller\System\Main::class . '@logout');
    });

    RouterMap::set(\App\Controller\System\Acl::class, '/acl', [
        'get', 'originLists', 'lists', 'add', 'edit', 'delete'
    ], $options);
    Router::post('/acl/validedKey', \App\Controller\System\Acl::class . '@validedKey', $options);

});