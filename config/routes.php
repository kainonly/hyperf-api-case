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

    Router::addGroup('/acl', function () {
        Router::post('/get', \App\Controller\System\Acl::class . '@get');
        Router::post('/originLists', \App\Controller\System\Acl::class . '@originLists');
        Router::post('/lists', \App\Controller\System\Acl::class . '@lists');
        Router::post('/add', \App\Controller\System\Acl::class . '@add');
        Router::post('/edit', \App\Controller\System\Acl::class . '@edit');
        Router::post('/delete', \App\Controller\System\Acl::class . '@delete');
    }, $options);

    Router::get('/acl/index', function () {
        return [
            'test' => 1
        ];
    });
});