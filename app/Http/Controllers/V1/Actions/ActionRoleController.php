<?php

namespace App\Http\Controllers\V1\Actions;

use App\Data\ActionRole\UpdateActionRoleData;
use App\Data\Actions\IndexActionData;
use App\Http\Controllers\Controller;
use App\Logics\Actions\ActionRoleIndexLogic;
use App\Logics\Actions\ActionRoleUpdateLogic;
use Illuminate\Http\JsonResponse;

class ActionRoleController extends Controller
{
    public function index(IndexActionData $data, ActionRoleIndexLogic $logic): JsonResponse
    {
        return $logic->run($data);
    }

    public function update(UpdateActionRoleData $data, ActionRoleUpdateLogic $logic): JsonResponse
    {
        return $logic->run($data);
    }
}
