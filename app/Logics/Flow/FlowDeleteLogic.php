<?php

namespace App\Logics\Flow;

use App\Core\Data\Flow\FlowByIdData;
use App\Core\Logics\Flow\FlowDeleteLogicBase;
use App\Models\Action;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

class FlowDeleteLogic extends FlowDeleteLogicBase
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
}
