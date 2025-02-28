<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
});

Route::controller(AuthController::class)->middleware('auth:api')->group(function () {
    Route::post('logout', 'logout')->middleware('auth:api');
    Route::post('is-allowed', 'isAllowed')->middleware('auth:api');
});