<?php

namespace App\Data\Flow;

use Spatie\LaravelData\Attributes\FromRouteParameter;
use Spatie\LaravelData\Data;

class FlowShowData extends Data
{
    public function __construct(
        #[FromRouteParameter('model')]
        public string $model,
        #[FromRouteParameter('id')]
        public string|int $id
    ) {}
}
