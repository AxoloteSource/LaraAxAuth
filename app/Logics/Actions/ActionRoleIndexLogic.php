<?php

namespace App\Logics\Actions;

use App\Core\Classes\Filter;
use App\Core\Data\IndexData;
use App\Core\Logics\IndexLogic;
use App\Http\Resources\Actions\RoleActionResource;
use App\Models\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\LaravelData\Data;

class ActionRoleIndexLogic extends IndexLogic
{
    public function __construct(protected Action $action)
    {
        parent::__construct($action);
    }

    public function run(IndexData|Data $input): JsonResponse
    {
        return parent::logic($input);
    }

    public function makeQuery(): Builder
    {
        $query = $this->model->newQuery();
        $query->withExists(['roles as active']);
        return $query;
    }

    protected function withResource(): AnonymousResourceCollection
    {
        return RoleActionResource::collection($this->response);
    }

    function searchActive(Filter $filter)
    {
        if (filter_var($filter->value, FILTER_VALIDATE_BOOLEAN)) {
            $this->queryBuilder->whereHas('roles');
        } else {
            $this->queryBuilder->whereDoesntHave('roles');
        }
    }

    protected function customFilters(): array
    {
        return [
            'active' => fn(Filter $filter) => $this->searchActive($filter),
            'name' => fn(Filter $filter) => $this->queryBuilder->where('name', 'like', "%{$filter->value}%"),
        ];
    }

    protected function tableHeaders(): array
    {
        return [
            'description' => __('Descripción'),
            'name' => __('Nombre'),
            'actions' => __('Acciones'),
        ];
    }
}
