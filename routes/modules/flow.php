<?php

use App\Http\Controllers\FlowController;
use Illuminate\Support\Facades\Route;

Route::controller(FlowController::class)->group(function () {
    Route::get('/{model}', 'index')->middleware('isAllow:auth.flow.index');
    Route::get('/{model}/{id}', 'show')->middleware('isAllow:auth.flow.show');
});
