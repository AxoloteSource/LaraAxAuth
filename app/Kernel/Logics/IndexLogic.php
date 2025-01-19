<?php

namespace App\Kernel\Logics;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Spatie\LaravelData\Data;

abstract class IndexLogic extends Logic
{
    public function __construct($model = null)
    {
        if (is_null($model)) {
            return;
        }
        $this->model = $model;
    }

    abstract public function run(Data $input): JsonResponse;

    protected function before(): bool
    {
        return true;
    }

    public function action(): self
    {
        $limit = $this->input->limit ?? 15;
        $page = $this->input->page ?? 1;

        $queryBuilder = $this->makeQuery();

        if (isset($this->input->filters)) {
            $queryBuilder = $this->runQueryFilters($this->input->filters, $queryBuilder);
        }

        if (isset($this->input->search)) {
            $queryBuilder = $this->runQueryWithSearch($this->input->search, $queryBuilder);
        }

        $this->response = $queryBuilder->paginate($limit, ['*'], 'page', $page);

        return $this;
    }

    protected function after(): bool
    {
        return true;
    }

    public function makeQuery(): Builder
    {
        if (method_exists($this->model, 'scopeIndex') || method_exists($this->model, 'index')) {
            return $this->model->index();
        }

        return $this->model->newQuery();
    }

    public function runQueryFilters(array $filters, $queryBuilder): Builder
    {
        foreach ($filters as $filter) {
            $operator = isset($filter['operator']) ? strtolower($filter['operator']) : '=';
            $value = $operator === 'like' ? "%{$filter['value']}%" : $filter['value'];
            $queryBuilder = $queryBuilder->where($filter['property'], $operator, $value);
        }

        return $queryBuilder;
    }

    public function runQueryWithSearch(string $search, Builder $queryBuilder): Builder
    {
        return $queryBuilder->where($this->getColumnSearch(), 'like', "%{$search}%");
    }

    protected function getColumnSearch(): string
    {
        return 'name';
    }

    protected function tableHeaders(): array
    {
        return [];
    }

    protected function response(): JsonResponse
    {
        return Response::successDataTable(
            $this->withResource(),
            $this->tableHeaders()
        );
    }
}
