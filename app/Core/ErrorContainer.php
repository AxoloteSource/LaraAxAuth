<?php

namespace App\Core;

use App\Core\Enums\Http;

class ErrorContainer
{
    public static array $error = [];

    public static function error(
        ?string $message = null,
        ?array $data = null,
        Http $status = Http::BadRequest
    ): void {
        self::$error = [
            'message' => $message,
            'data' => $data,
            'status' => $status,
        ];
    }

    public static function resetErrors(): void
    {
        self::$error = [];
    }
}
