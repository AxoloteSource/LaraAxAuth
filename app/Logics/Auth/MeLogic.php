<?php

namespace App\Logics\Auth;

use App\Core\Data\EmptyData;
use App\Core\Logics\Logic;
use App\Core\Traits\OnlyWithAction;
use App\Http\Resources\Auth\MeResource;
use Illuminate\Http\JsonResponse;

class MeLogic extends Logic
{
    use OnlyWithAction;

    public function run(): JsonResponse
    {
        return parent::logic(new EmptyData);
    }

    protected function action(): Logic
    {
        $this->model = $this->user();
        return $this;
    }

    protected function withResource(): MeResource
    {
        return new MeResource($this->model);
    }
}
