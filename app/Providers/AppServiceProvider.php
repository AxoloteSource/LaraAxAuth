<?php

namespace App\Providers;

use App\Enums\HttpErrors;
use App\Kernel\Responses\ResponseMacros;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResponseMacros::register();
    }
}
