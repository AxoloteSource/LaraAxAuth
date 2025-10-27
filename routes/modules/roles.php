<?php

use App\Http\Controllers\V1\Actions\ActionRoleController;
use App\Http\Controllers\V1\Roles\RoleActionController;
use App\Http\Controllers\V1\Roles\RoleController;
use Illuminate\Support\Facades\Route;

Route::controller(RoleActionController::class)->group(function () {
    Route::post('/attach/actions', 'store')->middleware('isAllow:auth.role.attach.actions');
});
Route::controller(RoleController::class)->group(function () {
    Route::get('', 'index')->middleware('isAllow:auth.role.index');
});

Route::controller(ActionRoleController::class)->group(function () {
    Route::get('/{id}/actions', 'index')->middleware('isAllow:auth.role.actions.index');
    Route::put('/{id}/actions/{actionId}', 'update')->middleware('isAllow:auth.role.actions.update');
});
