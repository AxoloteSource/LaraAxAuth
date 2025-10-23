<?php

namespace App\Logics\Flow;

use App\Core\Data\Flow\FlowIndexData;
use App\Core\Logics\Flow\FlowIndexLogicBase;
use App\Models\Action;
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
            'roles' => 'auth.role.index',
            'actions' => 'auth.action.index',
            'actions' => 'auth.role.actions.index',
        ];
    }
}
