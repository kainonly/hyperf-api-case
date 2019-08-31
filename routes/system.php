<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'main'
], function () {
    Route::post('login', 'MainController@login');
    Route::post('logout', 'MainController@logout');
    Route::post('verify', 'MainController@verify');
    Route::post('resource', 'MainController@resource');
    Route::post('information', 'MainController@information');
    Route::post('update', 'MainController@update');
    Route::post('uploads', 'MainController@uploads');
});

Route::group([
    'prefix' => 'acl'
], function () {
    Route::post('get', 'AclController@get');
    Route::post('originLists', 'AclController@originLists');
    Route::post('lists', 'AclController@lists');
    Route::post('add', 'AclController@add');
    Route::post('edit', 'AclController@edit');
    Route::post('delete', 'AclController@delete');
});

Route::group([
    'prefix' => 'resource'
], function () {
    Route::post('get', 'ResourceController@get');
    Route::post('originLists', 'ResourceController@originLists');
    Route::post('add', 'ResourceController@add');
    Route::post('edit', 'ResourceController@edit');
    Route::post('delete', 'ResourceController@delete');
});

