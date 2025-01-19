<?php

namespace App\Kernel;

use App\Kernel\Enums\HttpErrors;

trait KernelLogic
{
    protected function error(
        ?string $message = null,
        ?array $data = null,
        HttpErrors $status = HttpErrors::BadRequest
    ): false {
        ErrorContainer::error($message, $data, $status);

        return false;
    }
}
