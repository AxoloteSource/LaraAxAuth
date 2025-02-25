<?php

namespace App\Logics\Flow;

use App\Core\Logics\Flow\FlowStoreLogicBase;
use App\Data\Role\StoreRoleData;
use App\Models\Role;

class FlowStoreLogic extends FlowStoreLogicBase
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
            'roles' => StoreRoleData::class,
        ];
    }

    public function resources(): array
    {
        return [];
    }
}
