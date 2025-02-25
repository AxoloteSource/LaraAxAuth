<?php

use App\Http\Controllers\FlowController;
use Illuminate\Support\Facades\Route;

Route::controller(FlowController::class)->group(function () {
    Route::get('/{model}', 'index')->middleware('isAllow:auth.flow.index');
    Route::post('/{model}', 'store')->middleware('isAllow:auth.flow.store');
    Route::get('/{model}/{id}', 'show')->middleware('isAllow:auth.flow.show');
    Route::put('/{model}/{id}', 'update')->middleware('isAllow:auth.flow.update');
    Route::delete('/{model}/{id}', 'delete')->middleware('isAllow:auth.flow.delete');
});
