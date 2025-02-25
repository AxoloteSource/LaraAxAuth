<?php

namespace App\Core\Logics\Flow\Traits;

use App\Core\Enums\Http;

trait FlowLogic
{
    private string $modelRoute;

    abstract public function allowedModels(): array;

    abstract public function resources(): array;

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
