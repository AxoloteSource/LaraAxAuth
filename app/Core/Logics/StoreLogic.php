<?php

namespace App\Core\Logics;

use App\Core\Enums\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Spatie\LaravelData\Data;

abstract class StoreLogic extends Logic
{
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
        $this->model->fill($this->input->toArray())->save();
        $this->response = collect($this->model->toArray());

        return $this;
    }

    protected function after(): bool
    {
        return true;
    }

    protected function response(): JsonResponse
    {
        return Response::success(
            data: $this->withResource(),
            status: Http::Created
        );
    }
}
