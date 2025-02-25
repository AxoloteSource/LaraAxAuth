<?php

namespace App\Kernel\Logics\Flow\Traits;


use App\Kernel\Enums\Http;

trait FlowLogic
{
    private string $modelRoute;

    abstract public function allowedModels(): array;

    abstract public function resources(): array;

    protected function before(): bool
    {
        $this->modelRoute = $this->input->model;

        if (! $this->validIsAllowModel()) {
            return false;
        }
        $allowedModels = $this->allowedModels();
        $this->model = new $allowedModels[$this->modelRoute];

        return true;
    }

    protected function withResource(): mixed
    {
        if (array_key_exists($this->modelRoute, $this->resources())) {
            $resource = $this->resources()[$this->modelRoute];

            return $resource::collection($this->response);
        }

        return $this->response;
    }

    private function validIsAllowModel(): bool
    {
        if (array_key_exists($this->modelRoute, $this->allowedModels())) {
            return true;
        }

        return $this->error(
            __('Model Not Found'),
            ['model' => $this->modelRoute],
            Http::NotFound
        );
    }
}
