<?php

namespace App\Logics\Flow;

use App\Core\Data\Flow\FlowByIdData;
use App\Core\Logics\Flow\FlowShowLogicBase;
use App\Models\Action;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

class FlowShowLogic extends FlowShowLogicBase
{
    protected Data|FlowByIdData $input;

    public function run(Data|FlowByIdData $input): JsonResponse
    {
        return parent::logic($input);
    }

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

    public function publicModels(): array
    {
        return [];
    }

    public function isAllow(): array
    {
        return [
            'roles' => 'auth.role.show',
            'actions' => 'auth.action.show',
        ];
    }
}
