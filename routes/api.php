<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/')
    ->group(base_path('/routes/modules/auth.php'));

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('')
        ->group(base_path('routes/modules/flow.php'));
});
