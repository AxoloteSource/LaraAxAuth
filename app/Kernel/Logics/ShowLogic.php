<?php

namespace App\Kernel\Logics;

use App\Kernel\Enums\HttpErrors;
use App\Kernel\KernelLogic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Spatie\LaravelData\Data;

abstract class ShowLogic extends Logic
{
    use KernelLogic;

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

    protected function action(): self
    {
        $this->response = $this->makeQuery()->with($this->with())->first();

        return $this;
    }

    protected function after(): bool
    {
        return true;
    }

    protected function makeQuery(): Builder
    {
        if (method_exists($this->model, 'scopeShow') || method_exists($this->model, 'show')) {
            return $this->model->show();
        }

        return $this->model->newQuery()
            ->where('id', $this->input->id);
    }

    protected function with(): array
    {
        return [];
    }

    protected function response(): JsonResponse
    {
        if (is_null($this->response)) {
            return Response::error(
                message: 'Not Found', status: HttpErrors::NotFound
            );
        }

        return Response::success($this->withResource());
    }
}
