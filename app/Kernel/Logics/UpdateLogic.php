<?php

namespace App\Kernel\Logics;

use App\Kernel\KernelLogic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

abstract class UpdateLogic extends Logic
{
    use KernelLogic;

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
        $this->model = $this->model->find($this->input->id);
        return true;
    }

    protected function action(): Logic
    {
        if (! $this->model->exists) {
            $this->model = $this->model->find($this->input->id);
        }

        $this->model->fill($this->input->toArray());
        $this->model->save();
        $this->response = $this->model;

        return $this;
    }

    protected function after(): bool
    {
        return true;
    }
}
