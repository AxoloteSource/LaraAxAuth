<?php

namespace App\Core;

use App\Core\Enums\Http;

trait KernelLogic
{
    protected function error(
        ?string $message = null,
        ?array $data = null,
        Http $status = Http::BadRequest
    ): false {
        ErrorContainer::error($message, $data, $status);

        return false;
    }
}
