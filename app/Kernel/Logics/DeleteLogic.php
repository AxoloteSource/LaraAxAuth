<?php

namespace App\Kernel\Logics;

use App\Kernel\Enums\Http;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Spatie\LaravelData\Data;

abstract class DeleteLogic extends Logic
{
    abstract public function run(Data $input): JsonResponse;

    protected function before(): bool
    {
        return true;
    }

    protected function action(): Logic
    {
        $this->response = $this->makeQuery()->first();
        $this->response->delete();

        return $this;
    }

    protected function after(): bool
    {
        return true;
    }

    protected function makeQuery(): Builder
    {
        if (method_exists($this->model, 'scopeRemove') || method_exists($this->model, 'remove')) {
            return $this->model->remove();
        }

        return $this->model->newQuery()
            ->where('id', $this->input->id);
    }

    protected function response(): JsonResponse
    {
        if (is_null($this->response)) {
            return Response::error(
                message: 'Not Found', status: Http::NotFound
            );
        }

        return Response::success(
            data: $this->withResource(),
            status: Http::NoContent
        );
    }
}
