<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->away(config('app.away_url'));
});
