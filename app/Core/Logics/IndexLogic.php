<?php

namespace App\Core\Logics;

use App\Core\Classes\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;
use Spatie\LaravelData\Data;

abstract class IndexLogic extends Logic
{
    protected Builder $queryBuilder;

    protected LengthAwarePaginator $pagination;

    protected bool $withPagination = true;

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
            $this->queryBuilder = $this->runQueryWithSearch($this->input->search);
        }

        $this->queryBuilder->with($this->withRelations());

        if ($this->withPagination) {
            $this->pagination = $this->queryBuilder->paginate($limit, ['*'], 'page', $page);
            $this->response = $this->pagination->getCollection();
        } else {
            $this->response = $this->queryBuilder->get();
        }

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
        $customFilters = array_keys($this->customFilters());

        foreach ($filters as $filterData) {
            $property = $filterData['property'];
            $value = $filterData['value'];
            $operator = $filterData['operator'] ?? '=';

            $filter = new Filter($property, $value, $operator);

            if (in_array($property, $customFilters)) {
                $this->applyCustomFilter($filter);

                continue;
            }

            $this->queryBuilder = $filter->applyToQuery($this->queryBuilder);
        }

        return $this->queryBuilder;
    }

    public function runQueryWithSearch(string $search): Builder
    {
        if (in_array('search', array_keys($this->customFilters()))) {
            $this->applyCustomFilter(new Filter('search', $search, 'like'));

            return $this->queryBuilder;
        }

        return $this->queryBuilder->where($this->getColumnSearch(), 'like', "%{$search}%");
    }

    protected function getColumnSearch(): string
    {
        return 'name';
    }

    protected function tableHeaders(): array
    {
        if (method_exists($this->model, 'getTableHeaders')) {
            return $this->model->getTableHeaders();
        }

        return [];
    }

    protected function withRelations(): array
    {
        return [];
    }

    protected function response(): JsonResponse
    {
        if ($this->withPagination) {
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

        return Response::success(
            $this->withResource(),
        );
    }

    protected function customFilters(): array
    {
        return [];
    }

    protected function applyCustomFilter(Filter $filter): void
    {
        $customFilters = $this->customFilters();
        $property = $filter->property;

        if (isset($customFilters[$property])) {
            $filterCallback = $customFilters[$property];
            if (! is_callable($filterCallback)) {
                throw new \InvalidArgumentException("Filter for property {$property} is not callable.");
            }

            $filterCallback($filter);
        }
    }
}
