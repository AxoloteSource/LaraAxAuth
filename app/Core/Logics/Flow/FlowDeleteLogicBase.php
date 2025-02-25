<?php

namespace App\Core\Logics\Flow;

use App\Core\Data\Flow\FlowByIdData;
use App\Core\Logics\DeleteLogic;
use App\Core\Logics\Flow\Traits\FlowLogic;
use App\Core\Logics\Flow\Traits\WithoutValidate;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

abstract class FlowDeleteLogicBase extends DeleteLogic
{
    use FlowLogic, WithoutValidate;

    protected Data|FlowByIdData $input;

    public function run(Data|FlowByIdData $input): JsonResponse
    {
        return parent::logic($input);
    }
}
