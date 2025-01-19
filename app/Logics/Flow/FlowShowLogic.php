<?php

namespace App\Logics\Flow;

use App\Data\Flow\FlowIndexData;
use App\Data\Flow\FlowShowData;
use App\Kernel\Logics\FlowLogic;
use App\Kernel\Logics\ShowLogic;
use App\Models\Action;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

class FlowShowLogic extends ShowLogic
{
    use FlowLogic;

    protected Data|FlowIndexData $input;

    public function run(Data|FlowShowData $input): JsonResponse
    {
        return parent::logic($input);
    }

    private array $allowedModels = [
        'roles' => Role::class,
        'actions' => Action::class,
    ];

    private array $resources = [];

    private array $searchColum = [];
}
