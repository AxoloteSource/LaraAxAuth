<?php

namespace App\Data\Actions;

use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Attributes\FromRouteParameter;
use Spatie\LaravelData\Data;

class IndexActionData extends Data
{
    public function __construct(
        #[FromRouteParameter('id'), Rule(['required', 'exists:roles,id'])]
        public string $id,
    ) {}
}
