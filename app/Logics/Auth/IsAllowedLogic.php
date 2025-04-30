<?php

namespace App\Logics\Auth;

use App\Core\Logics\Logic;
use App\Core\Traits\OnlyWithAction;
use App\Data\Auth\IsAllowedData;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class IsAllowedLogic extends Logic
{
    use OnlyWithAction;

    protected Data|IsAllowedData $input;

    public function run(IsAllowedData $input): JsonResponse
    {
        return parent::logic($input);
    }

    protected function action(): Logic
    {
        $this->response = $this->checkRoles();

        return $this;
    }

    private function checkRoles(): Collection
    {
        $result = collect();

        foreach ($this->input->actions as $action) {
            $result = $result->merge([$action => $this->user()->belongsToAction($action)]);
        }

        return $result;
    }
}
