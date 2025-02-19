<?php

namespace App\Kernel\Logics\Flow;

use App\Kernel\Data\Flow\FlowByIdData;
use App\Kernel\Logics\DeleteLogic;
use App\Kernel\Logics\Flow\Traits\FlowLogic;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

abstract class FlowDeleteLogicBase extends DeleteLogic
{
    use FlowLogic;

    protected Data|FlowByIdData $input;

    public function run(Data|FlowByIdData $input): JsonResponse
    {
        return parent::logic($input);
    }
}
