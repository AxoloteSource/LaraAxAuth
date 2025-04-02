<?php

namespace App\Core\Data\Flow;

use Spatie\LaravelData\Attributes\FromRouteParameter;
use Spatie\LaravelData\Data;

class FlowByIdData extends Data
{
    public function __construct(
        #[FromRouteParameter('model')]
        public string $model,
        #[FromRouteParameter('id')]
        public mixed $id
    ) {}
}
