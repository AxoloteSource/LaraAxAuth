<?php

namespace App\Core\Logics\Flow\Traits;

trait WithoutValidate
{
    protected function before(): bool
    {
        $this->modelRoute = $this->input->model;

        if (! $this->validIsAllowModel()) {
            return false;
        }

        if (! $this->validateAction()) {
            return false;
        }

        $allowedModels = $this->allowedModels();
        $this->model = new $allowedModels[$this->modelRoute];

        return true;
    }
}
