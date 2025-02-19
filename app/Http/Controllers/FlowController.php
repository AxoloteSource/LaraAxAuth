<?php

namespace App\Http\Controllers;

use App\Kernel\Data\Flow\FlowByIdData;
use App\Kernel\Data\Flow\FlowIndexData;
use App\Logics\Flow\FlowDeleteLogic;
use App\Logics\Flow\FlowIndexLogic;
use App\Logics\Flow\FlowShowLogic;
use Illuminate\Http\JsonResponse;

class FlowController extends Controller
{
    public function index(FlowIndexData $data, FlowIndexLogic $logic): JsonResponse
    {
        return $logic->run($data);
    }

    public function show(FlowByIdData $data, FlowShowLogic $logic): JsonResponse
    {
        return $logic->run($data);
    }

    public function delete(FlowByIdData $data, FlowDeleteLogic $logic): JsonResponse
    {
        return $logic->run($data);
    }
}
