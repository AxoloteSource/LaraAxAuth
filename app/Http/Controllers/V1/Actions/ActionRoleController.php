<?php

namespace App\Http\Controllers\V1\Actions;

use App\Data\Actions\IndexActionData;
use App\Http\Controllers\Controller;
use App\Logics\Actions\ActionRoleIndexLogic;
use Illuminate\Http\JsonResponse;

class ActionRoleController extends Controller
{
    public function index(IndexActionData $data, ActionRoleIndexLogic $logic): JsonResponse
    {
        return $logic->run($data);
    }
}
