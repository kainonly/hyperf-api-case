<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'main'
], function () {
    Route::post('login', 'Main@login');
    Route::post('logout', 'Main@logout');
    Route::post('verify', 'Main@verify');
    Route::post('menu', 'Main@menu');
    Route::post('uploads', 'Main@uploads');
    Route::post('information', 'Main@Information');
    Route::post('update', 'Main@update');
});

Route::group([
    'prefix' => 'router'
], function () {
    Route::post('get', 'Router@get');
    Route::post('originLists', 'Router@originLists');
    Route::post('add', 'Router@add');
    Route::post('edit', 'Router@edit');
    Route::post('delete', 'Router@delete');
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
    'prefix' => 'staff'
], function () {
    Route::post('get', 'Staff@get');
    Route::post('originLists', 'Staff@originLists');
    Route::post('lists', 'Staff@lists');
    Route::post('add', 'Staff@add');
    Route::post('edit', 'Staff@edit');
    Route::post('delete', 'Staff@delete');
    Route::post('validate_username', 'Staff@validateUsername');
});
