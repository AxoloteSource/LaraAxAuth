<?php

namespace App\Core\Logics;

use App\Core\CoreLogic;
use App\Core\Enums\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

abstract class UpdateLogic extends Logic
{
    use CoreLogic;

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
        $foundModel = $this->model->find($this->input->id);

        if (is_null($foundModel)) {
            return $this->error(message: 'Not Found', status: Http::NotFound);
        }

        $this->model = $foundModel;

        return true;
    }

    protected function action(): Logic
    {
        if (! $this->model->exists) {
            $foundModel = $this->model->find($this->input->id);
            if (is_null($foundModel)) {
                $this->error(message: 'Not Found', status: Http::NotFound);

                return $this;
            }

            $this->model = $foundModel;
        }

        $this->model->fill($this->input->toArray());
        $this->model->save();
        $this->response = collect($this->model);

        return $this;
    }

    protected function after(): bool
    {
        return true;
    }
}
