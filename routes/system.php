<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'main'
], function () {
    Route::post('login', 'Main@login');
    Route::post('logout', 'Main@logout');
    Route::post('verify', 'Main@verify');
    Route::post('resource', 'Main@resource');
    Route::post('uploads', 'Main@uploads');
    Route::post('information', 'Main@information');
    Route::post('update', 'Main@update');
});
