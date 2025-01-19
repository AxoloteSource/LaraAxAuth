<?php

namespace App\Kernel\Logics;

use App\Kernel\Enums\HttpErrors;

trait FlowLogic
{
    private string $modelRoute;

    protected function before(): bool
    {
        $this->modelRoute = $this->input->model;

        if (! $this->validIsAllowModel()) {
            return false;
        }

        $this->model = new $this->allowedModels[$this->modelRoute];

        return true;
    }

    protected function withResource(): mixed
    {
        if (array_key_exists($this->modelRoute, $this->resources)) {
            $resource = $this->resources[$this->modelRoute];

            return $resource::collection($this->response);
        }

        return $this->response;
    }

    public function validIsAllowModel(): bool
    {
        if (array_key_exists($this->modelRoute, $this->allowedModels)) {
            return true;
        }

        return $this->error(
            __('Model Not Found'),
            ['model' => $this->modelRoute],
            HttpErrors::NotFound
        );
    }
}
