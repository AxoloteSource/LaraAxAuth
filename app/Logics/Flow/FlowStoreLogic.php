<?php

namespace App\Logics\Flow;

use App\Core\Logics\Flow\FlowStoreLogicBase;
use App\Data\Actions\StoreActionData;
use App\Data\Role\StoreRoleData;
use App\Models\Action;
use App\Models\Role;

class FlowStoreLogic extends FlowStoreLogicBase
{
    public function allowedModels(): array
    {
        return [
            'roles' => Role::class,
            'actions' => Action::class,
        ];
    }

    public function validates(): array
    {
        return [
            'roles' => StoreRoleData::class,
            'actions' => StoreActionData::class,
        ];
    }

    public function resources(): array
    {
        return [];
    }

    public function publicModels(): array
    {
        return [];
    }

    public function isAllow(): array
    {
        return [
            'roles' => 'auth.role.store',
            'actions' => 'auth.action.store',
        ];
    }
}
