<?php

use App\Modules\User\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'api',
    'middleware' => 'api',
], function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);
    Route::post('/register', [UserController::class, 'store']);
    Route::middleware('auth:sanctum')->put('/user/{user}', [UserController::class, 'update']);
});
