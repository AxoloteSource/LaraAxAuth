<?php

namespace App\Kernel\Logics;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

abstract class StoreLogic extends Logic
{
    public function __construct(Model $model)
    {
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
        $this->response = $this->model;

        return $this;
    }

    protected function after(): bool
    {
        return true;
    }
}
