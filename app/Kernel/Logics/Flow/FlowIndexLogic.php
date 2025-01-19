<?php

namespace App\Kernel\Logics\Flow;

use App\Data\Flow\FlowIndexData;
use App\Kernel\Enums\HttpErrors;
use App\Kernel\KernelLogic;
use App\Kernel\Logics\IndexLogic;
use App\Models\Action;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

class FlowIndexLogic extends IndexLogic
{
    use KernelLogic;

    protected Data|FlowIndexData $input;

    private string $modelRoute;

    private array $allowedModels = [
        'roles' => Role::class,
        'actions' => Action::class,
    ];

    private array $resources = [];

    private array $searchColum = [];

    public function run(Data|FlowIndexData $input): JsonResponse
    {
        return parent::logic($input);
    }

    protected function before(): bool
    {
        $this->modelRoute = $this->input->model;

        if (! $this->validIsAllowModel()) {
            return false;
        }

        $this->model = new $this->allowedModels[$this->modelRoute];

        return true;
    }

    protected function withResource(): mixed
    {
        if (array_key_exists($this->modelRoute, $this->resources)) {
            $resource = $this->resources[$this->modelRoute];

            return $resource::collection($this->response);
        }

        return $this->response;
    }

    public function runQueryWithSearch(string $search, Builder $queryBuilder): Builder
    {
        $colum = array_key_exists($this->modelRoute, $this->searchColum)
            ? $this->searchColum[$this->modelRoute]
            : $this->getColumnSearch();

        return $queryBuilder->where($colum, 'like', "%{$search}%");
    }

    public function validIsAllowModel(): bool
    {
        if (array_key_exists($this->modelRoute, $this->allowedModels)) {
            return true;
        }

        return $this->error(
            __('Model Not Found'),
            ['model' => $this->modelRoute],
            HttpErrors::NotFound
        );
    }
}
