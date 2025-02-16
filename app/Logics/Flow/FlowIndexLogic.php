<?php

namespace App\Logics\Flow;

use App\Kernel\Data\Flow\FlowIndexData;
use App\Kernel\Logics\Flow\FlowIndexLogicBase;
use App\Models\Action;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

class FlowIndexLogic extends FlowIndexLogicBase
{
    protected Data|FlowIndexData $input;

    public function run(Data|FlowIndexData $input): JsonResponse
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
}
