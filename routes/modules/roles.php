<?php

use App\Http\Controllers\V1\Roles\RoleActionController;
use App\Http\Controllers\V1\Roles\RoleController;
use Illuminate\Support\Facades\Route;

Route::controller(RoleActionController::class)->group(function () {
    Route::post('/attach/actions', 'store')->middleware('isAllow:auth.role.attach.actions');
});
Route::controller(RoleController::class)->group(function () {
    Route::get('', 'index')->middleware('isAllow:auth.role.index');
});
