<?php

namespace App\Core\Logics\Flow;

use App\Core\Data\Flow\FlowByIdData;
use App\Core\Logics\Flow\Traits\FlowLogic;
use App\Core\Logics\Flow\Traits\WhitSearch;
use App\Core\Logics\ShowLogic;
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
