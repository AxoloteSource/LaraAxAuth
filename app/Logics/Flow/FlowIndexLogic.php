<?php

namespace App\Logics\Flow;

use App\Kernel\Logics\Flow\FlowIndexLogicBase;
use App\Models\Action;
use App\Models\Role;

class FlowIndexLogic extends FlowIndexLogicBase
{

    public function allowedModels(): array
    {
        return [
            'roles' => Role::class,
            'actions' => Action::class,
        ];
    }

    public function resources(): array
    {
        return [];
    }

    public function searchColum(): array
    {
        return [];
    }
}
