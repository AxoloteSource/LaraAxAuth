<?php

namespace App\Logics\Flow;

use App\Kernel\Data\Flow\FlowShowData;
use App\Kernel\Logics\Flow\FlowShowLogicBase;
use App\Models\Action;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

class FlowShowLogic extends FlowShowLogicBase
{

    protected Data|FlowShowData $input;

    public function run(Data|FlowShowData $input): JsonResponse
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
