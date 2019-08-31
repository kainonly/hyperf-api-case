<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'main'
], function () {
    Route::post('login', 'Main@login');
    Route::post('logout', 'Main@logout');
    Route::post('verify', 'Main@verify');
    Route::post('resource', 'Main@resource');
    Route::post('information', 'Main@information');
    Route::post('update', 'Main@update');
    Route::post('uploads', 'Main@uploads');
});

Route::group([
    'prefix' => 'main'
], function () {
    Route::post('get', 'Acl@get');
    Route::post('originLists', 'Acl@originLists');
    Route::post('lists', 'Acl@lists');
    Route::post('add', 'Acl@add');
    Route::post('edit', 'Acl@edit');
    Route::post('delete', 'Acl@delete');
});
