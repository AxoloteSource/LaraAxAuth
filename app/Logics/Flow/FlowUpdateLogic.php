<?php

namespace App\Logics\Flow;

use App\Data\Role\UpdateRoleData;
use App\Kernel\Logics\Flow\FlowUpdateLogicBase;
use App\Models\Role;

class FlowUpdateLogic extends FlowUpdateLogicBase
{
    public function allowedModels(): array
    {
        return [
            'roles' => Role::class,
        ];
    }

    public function validates(): array
    {
        return [
            'roles' => UpdateRoleData::class,
        ];
    }

    public function resources(): array
    {
        return [];
    }
}
