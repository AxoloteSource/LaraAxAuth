<?php

namespace App\Data\Role;

use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class UpdateRoleData extends Data
{
    public function __construct(
        #[Rule(['required', 'unique:roles,name'])]
        public string $name,
        #[Rule(['required'])]
        public string $description,
        #[Rule(['required', 'exists:roles,id'])]
        public string $id
    ) {}
}
