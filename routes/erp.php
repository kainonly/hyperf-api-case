<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'main'
], function () {
    Route::post('login', 'Main@login');
    Route::post('check', 'Main@check');
    Route::post('menu', 'Main@menu');
    Route::post('uploads', 'Main@uploads');
});

Route::group([
    'prefix' => 'center'
], function () {
    Route::post('clear', 'Center@clear');
    Route::post('information', 'Center@Information');
    Route::post('update', 'Center@update');
    Route::post('get', 'Center@get');
});

Route::group([
    'prefix' => 'router'
], function () {
    Route::post('get', 'Router@get');
    Route::post('originLists', 'Router@originLists');
    Route::post('add', 'Router@add');
    Route::post('edit', 'Router@edit');
    Route::post('delete', 'Router@delete');
    Route::post('sort', 'Router@sort');
    Route::post('validate_routerlink', 'Router@validateRouterlink');
});

Route::group([
    'prefix' => 'api_type'
], function () {
    Route::post('originLists', 'ApiType@originLists');
    Route::post('add', 'ApiType@add');
    Route::post('edit', 'ApiType@edit');
    Route::post('delete', 'ApiType@delete');
});

Route::group([
    'prefix' => 'api'
], function () {
    Route::post('get', 'Api@get');
    Route::post('originLists', 'Api@originLists');
    Route::post('lists', 'Api@lists');
    Route::post('add', 'Api@add');
    Route::post('edit', 'Api@edit');
    Route::post('delete', 'Api@delete');
    Route::post('validate_api', 'Api@validateApi');
});

Route::group([
    'prefix' => 'role'
], function () {
    Route::post('get', 'Role@get');
    Route::post('originLists', 'Role@originLists');
    Route::post('lists', 'Role@lists');
    Route::post('add', 'Role@add');
    Route::post('edit', 'Role@edit');
    Route::post('delete', 'Role@delete');
});

Route::group([
    'prefix' => 'admin'
], function () {
    Route::post('get', 'Admin@get');
    Route::post('originLists', 'Admin@originLists');
    Route::post('lists', 'Admin@lists');
    Route::post('add', 'Admin@add');
    Route::post('edit', 'Admin@edit');
    Route::post('delete', 'Admin@delete');
    Route::post('validate_username', 'Admin@validateUsername');
});

Route::group([
    'prefix' => 'page'
], function () {
    Route::post('get', 'Page@get');
    Route::post('originLists', 'Page@originLists');
    Route::post('add', 'Page@add');
    Route::post('edit', 'Page@edit');
    Route::post('delete', 'Page@delete');
    Route::post('sort', 'Page@sort');
    Route::post('validate_routerlink', 'Page@validateRouterlink');
});
