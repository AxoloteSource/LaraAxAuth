<?php

namespace App\Kernel;

use App\Kernel\Enums\HttpErrors;

class ErrorContainer
{
    public static array $error = [];

    public static function error(
        ?string $message = null,
        ?array $data = null,
        HttpErrors $status = HttpErrors::BadRequest
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
