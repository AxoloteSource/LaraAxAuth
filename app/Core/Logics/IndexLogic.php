<?php

namespace App\Core\Logics;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;
use Spatie\LaravelData\Data;

abstract class IndexLogic extends Logic
{
    protected Builder $queryBuilder;

    protected private(set) LengthAwarePaginator $pagination;

    public function __construct(?Model $model = null)
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
        $this->queryBuilder = $this->makeQuery();

        if (isset($this->input->filters)) {
            $this->queryBuilder = $this->runQueryFilters($this->input->filters);
        }

        if (isset($this->input->search)) {
            logger('existe el sear ', [$this->input->search]);
            $this->queryBuilder = $this->runQueryWithSearch($this->input->search);
        }

        $this->pagination = $this->queryBuilder->paginate($limit, ['*'], 'page', $page);
        $this->response = $this->pagination->getCollection();

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

    public function runQueryFilters(array $filters): Builder
    {
        foreach ($filters as $filter) {
            $operator = isset($filter['operator']) ? strtolower($filter['operator']) : '=';
            $value = $operator === 'like' ? "%{$filter['value']}%" : $filter['value'];
            $this->queryBuilder->where($filter['property'], $operator, $value);
        }

        return $this->queryBuilder;
    }

    public function runQueryWithSearch(string $search): Builder
    {
        return $this->queryBuilder->where($this->getColumnSearch(), 'like', "%{$search}%");
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
            new LengthAwarePaginator(
                $this->withResource(),
                $this->pagination->total(),
                $this->pagination->perPage(),
                $this->pagination->currentPage()
            ),
            $this->tableHeaders()
        );
    }
}
