<?php

namespace App\Providers;

use App\Enums\HttpErrors;
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
        Response::macro('success', function ($data, ?string $message = null, HttpErrors $status = HttpErrors::Success): JsonResponse {
            return Response::json([
                'status' => 'OK',
                'message' => $message,
                'data' => $data,
            ], $status->value);
        });

        Response::macro('error', function ($message, ?array $data = null, HttpErrors $status = HttpErrors::BadRequest): JsonResponse {
            return Response::json([
                'status' => 'error',
                'message' => $message,
                'data' => $data,
            ], $status->value);
        });

        Response::macro('unauthenticated', function (): JsonResponse {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated',
            ], 401);
        });

        Response::macro('unauthorized', function (): JsonResponse {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 403);
        });
    }
}
