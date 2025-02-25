<?php

namespace App\Core\Data;

use Spatie\LaravelData\Attributes\FromRouteParameter;
use Spatie\LaravelData\Attributes\Validation\Exists;

class IndexShow
{
    public function __construct(
        #[FromRouteParameter('id'), Exists()]
        public int $id,
    ) {}
}
