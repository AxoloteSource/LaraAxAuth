<?php

namespace App\Data\ActionRole;

use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Attributes\FromRouteParameter;
use Spatie\LaravelData\Data;

class UpdateActionRoleData extends Data
{
    public function __construct(
        #[FromRouteParameter('id'), Rule(['required', 'exists:roles,id'])]
        public string $id,
        #[Rule(['required', 'exists:actions,id'])]
        public string $action_id,
        #[Rule(['required', 'boolean'])]
        public bool $active,
    ) {}
}
