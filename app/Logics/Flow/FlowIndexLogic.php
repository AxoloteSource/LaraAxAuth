<?php

namespace App\Logics\Flow;

use App\Data\Flow\FlowIndexData;
use App\Kernel\KernelLogic;
use App\Kernel\Logics\FlowLogic;
use App\Kernel\Logics\IndexLogic;
use App\Models\Action;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

class FlowIndexLogic extends IndexLogic
{
    use FlowLogic;

    protected Data|FlowIndexData $input;

    public function run(Data|FlowIndexData $input): JsonResponse
    {
        return parent::logic($input);
    }

    private array $allowedModels = [
        'roles' => Role::class,
        'actions' => Action::class,
    ];

    private array $resources = [];

    private array $searchColum = [];

    public function runQueryWithSearch(string $search, Builder $queryBuilder): Builder
    {
        $colum = array_key_exists($this->modelRoute, $this->searchColum)
            ? $this->searchColum[$this->modelRoute]
            : $this->getColumnSearch();

        return $queryBuilder->where($colum, 'like', "%{$search}%");
    }
}
