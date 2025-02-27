<?php

namespace App\Logics\Auth;

use App\Core\Data\EmptyData;
use App\Core\Logics\Logic;
use App\Core\Traits\OnlyWithAction;
use Illuminate\Http\JsonResponse;

class LogoutLogic extends Logic
{
    use OnlyWithAction;

    public function run(): JsonResponse
    {
        return parent::logic(new EmptyData);
    }

    protected function action(): Logic
    {
        $token = auth()->user()->token();
        $token->revoke();

        return $this;
    }
}
