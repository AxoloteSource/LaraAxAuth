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
        $this->model = $this->model->find($this->input->id);
        $foundModel = $this->model->find($this->input->id);

        if (is_null($foundModel)) {
            return $this->error(message: 'Not Found', status: Http::NotFound);
        }

        $this->model = $foundModel;

        return true;
    }

    protected function action(): self
    {
        $foundModel = $this->makeQuery()->first();

        if ($foundModel) {
            $this->model = $foundModel;
            $this->response = collect($this->model);
        } else {
            $this->response = null;
        }

        return $this;
    }

    protected function after(): bool
    {
        return true;
    }

    protected function makeQuery(): Builder
    {
        if (method_exists($this->model, 'scopeShow') || method_exists($this->model, 'show')) {
            return $this->model->show($this->input->id);
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
