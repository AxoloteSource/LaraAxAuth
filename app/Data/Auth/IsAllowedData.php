<?php

namespace App\Data\Auth;

use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class IsAllowedData extends Data
{
    public function __construct(
        #[Rule('required|array')]
        public array $actions,
    ) {}
}
