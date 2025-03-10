<?php

namespace App\Data\Actions;

use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class StoreActionData extends Data
{
    public function __construct(
        #[Rule(['required', 'unique:actions,name'])]
        public string $name,
        #[Rule(['required'])]
        public string $description,
    ) {}
}
