<?php

namespace App\Data\Actions;

use App\Core\Data\IndexData;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Attributes\FromRouteParameter;

class IndexActionData extends IndexData
{
    public function __construct(
        #[FromRouteParameter('id'), Rule(['required', 'exists:roles,id'])]
        public string $id,
    ) {   }
}
