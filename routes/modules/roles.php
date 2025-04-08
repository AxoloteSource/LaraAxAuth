<?php

use App\Http\Controllers\V1\Roles\RoleActionController;
use Illuminate\Support\Facades\Route;

Route::controller(RoleActionController::class)->group(function () {
    Route::post('/attach/actions', 'store')->middleware('isAllow:auth.role.attach.actions');
});
