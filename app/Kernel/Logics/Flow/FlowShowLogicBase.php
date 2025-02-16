<?php

namespace App\Kernel\Logics\Flow;

use App\Kernel\Data\Flow\FlowShowData;
use App\Kernel\Logics\ShowLogic;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

abstract class FlowShowLogicBase extends ShowLogic
{
    use FlowLogic;

    protected Data|FlowShowData $input;

    public function run(Data|FlowShowData $input): JsonResponse
    {
        return parent::logic($input);
    }
}
