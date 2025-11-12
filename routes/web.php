<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->away(env('AWAY_FRONTEND_URL','https://www.google.com'));
});
