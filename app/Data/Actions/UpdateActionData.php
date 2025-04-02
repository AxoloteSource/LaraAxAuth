<?php

namespace App\Data\Actions;

use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class UpdateActionData extends Data
{
    public function __construct(
        #[Rule(['required', 'unique:actions,name'])]
        public string $name,
        #[Rule(['required'])]
        public string $description,
        #[Rule(['required', 'exists:actions,id'])]
        public string $id
    ) {}
}
