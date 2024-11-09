<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');

    //TODO IRENEH
    //Route::post('logout', 'logout');
    //Route::post('refresh', 'refresh');
});
