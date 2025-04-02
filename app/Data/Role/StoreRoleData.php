<?php

namespace App\Data\Role;

use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class StoreRoleData extends Data
{
    public function __construct(
        #[Rule(['required', 'unique:roles,name'])]
        public string $name,
        #[Rule(['required', 'unique:roles,key'])]
        public string $key,
        #[Rule(['required'])]
        public string $description,
    ) {}
}
