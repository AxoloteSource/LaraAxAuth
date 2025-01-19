<?php

namespace App\Http\Controllers;

use App\Data\Flow\FlowIndexData;
use App\Data\Flow\FlowShowData;
use App\Logics\Flow\FlowIndexLogic;
use App\Logics\Flow\FlowShowLogic;
use Illuminate\Http\JsonResponse;

class FlowController extends Controller
{
    public function index(FlowIndexData $data, FlowIndexLogic $logic): JsonResponse
    {
        return $logic->run($data);
    }

    public function show(FlowShowData $data, FlowShowLogic $logic): JsonResponse
    {
        return $logic->run($data);
    }
}
