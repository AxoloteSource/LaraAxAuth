<?php

namespace App\Core\Data\Flow;

use App\Core\Data\IndexData;
use Spatie\LaravelData\Attributes\FromRouteParameter;

class FlowIndexData extends IndexData
{
    public function __construct(
        #[FromRouteParameter('model')]
        public string $model,
    ) {}
}
