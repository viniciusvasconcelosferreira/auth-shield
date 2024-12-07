<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'web',
], function () {
    Route::get('/test-user-web', function () {
        return view('welcome');
    });
});
