<?php

namespace App\Data\Role;

use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\References\RouteParameterReference;

class UpdateRoleData extends Data
{
    public function __construct(
        #[Unique('roles', 'name', ignore: new RouteParameterReference('id'))]
        public string $name,
        #[Rule(['required'])]
        public string $description,
        #[Rule(['required', 'exists:roles,id'])]
        public string $id
    ) {}
}
