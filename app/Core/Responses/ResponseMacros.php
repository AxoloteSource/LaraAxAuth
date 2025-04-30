<?php

namespace App\Core\Responses;

use App\Core\Enums\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;

class ResponseMacros
{
    public static function register()
    {
        Response::macro(
            'success',
            function (
                array|bool|Model|Collection|JsonResource|JsonResponse|null $data,
                ?string $message = null,
                Http $status = Http::Success
            ): JsonResponse {
                return Response::json([
                    'status' => 'OK',
                    'message' => $message,
                    'data' => $data,
                ], $status->value);
            });

        Response::macro(
            'successDataTableNotPaginate',
            function (
                array|bool|Model|Collection|JsonResource $data,
                array $tableHeaders
            ): JsonResponse {
                $columns = collect($tableHeaders)->map(function (mixed $value, string $key) {
                    return [
                        'accessor' => $key,
                        'title' => $value,
                    ];
                })->values();

                return Response::json([
                    'data' => $data,
                    'columns' => $columns,
                ], Http::PartialContent->value);
            });

        Response::macro(
            'successPagination',
            function (
                ?LengthAwarePaginator $data,
                $message = null
            ): JsonResponse {
                return Response::json([
                    'status' => 'OK',
                    'message' => $message,
                    'data' => $data,
                ], 206);
            });

        Response::macro(
            'successDataTable',
            function (
                ?LengthAwarePaginator $data,
                array $tableHeaders
            ): JsonResponse {
                $data = collect($data->toArray())->merge([
                    'columns' => collect($tableHeaders)->map(function (mixed $value, string $key) {
                        return [
                            'accessor' => $key,
                            'title' => $value,
                        ];
                    })->values(),
                ]);

                return Response::json($data, Http::PartialContent->value);
            });

        Response::macro(
            'error',
            function (
                ?string $message = null,
                ?array $data = null,
                Http $status = Http::UnprocessableEntity
            ): JsonResponse {
                return Response::json([
                    'status' => 'error',
                    'message' => $message,
                    'data' => $data,
                ], $status->value);
            });

        Response::macro(
            'unauthenticated',
            function (): JsonResponse {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthenticated',
                ], 401);
            });

        Response::macro(
            'unauthorized',
            function (): JsonResponse {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized',
                ], 403);
            });
    }
}
