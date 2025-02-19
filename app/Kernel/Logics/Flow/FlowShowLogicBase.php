<?php

namespace App\Kernel\Logics\Flow;

use App\Kernel\Data\Flow\FlowByIdData;
use App\Kernel\Logics\Flow\Traits\FlowLogic;
use App\Kernel\Logics\Flow\Traits\WhitSearch;
use App\Kernel\Logics\ShowLogic;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

abstract class FlowShowLogicBase extends ShowLogic
{
    use FlowLogic, WhitSearch;

    protected Data|FlowByIdData $input;

    public function run(Data|FlowByIdData $input): JsonResponse
    {
        return parent::logic($input);
    }
}
