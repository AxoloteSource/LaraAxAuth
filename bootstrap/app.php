<?php

use App\Core\Middleware\IsAllow;
use App\Core\Middleware\SetHeaders;
use App\Core\Middleware\TransactionMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function (Application $app) {
            Route::prefix('/api/v1')
                ->middleware(['setHeaders', 'api', 'transaction'])
                ->group(base_path('routes/api.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'isAllow' => IsAllow::class,
            'setHeaders' => SetHeaders::class,
            'transaction' => TransactionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ValidationException $e) {
            return Response::error(
                null,
                $e->errors(),
            );
        });
    })->create();
