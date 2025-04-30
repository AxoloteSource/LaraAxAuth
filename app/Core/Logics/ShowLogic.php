<?php

namespace App\Core\Logics;

use App\Core\Enums\Http;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Spatie\LaravelData\Data;
use Symfony\Component\HttpFoundation\StreamedResponse;

abstract class ShowLogic extends Logic
{
    public function __construct(?Model $model = null)
    {
        if (is_null($model)) {
            return;
        }
        $this->model = $model;
    }

    abstract public function run(Data $input): JsonResponse|StreamedResponse;

    protected function before(): bool
    {
        return true;
    }

    protected function action(): self
    {
        $this->response = collect($this->makeQuery()->with($this->with())->first());

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

    protected function response(): JsonResponse|StreamedResponse
    {
        if (is_null($this->response)) {
            return Response::error(
                message: 'Not Found', status: Http::NotFound
            );
        }

        return Response::success($this->withResource());
    }
}
