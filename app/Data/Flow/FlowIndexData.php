<?php

namespace App\Data\Flow;

use App\Kernel\Data\IndexData;
use Spatie\LaravelData\Attributes\FromRouteParameter;

class FlowIndexData extends IndexData
{
    public function __construct(
        #[FromRouteParameter('model')]
        public string $model,
    ) {}
}
