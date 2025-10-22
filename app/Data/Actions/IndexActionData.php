<?php

namespace App\Data\Actions;

use App\Core\Data\IndexData;
use Spatie\LaravelData\Attributes\FromRouteParameter;
use Spatie\LaravelData\Attributes\Validation\Rule;

class IndexActionData extends IndexData
{
    public function __construct(
        #[FromRouteParameter('id'), Rule(['required', 'exists:roles,id'])]
        public string $id,
    ) {}
}
