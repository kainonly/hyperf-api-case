<?php

use Illuminate\Support\Facades\Route;

Route::prefix('main')->group(function () {
    Route::get('/', 'Main@index');
});
