<?php

namespace App\Http\Controllers\V1\Roles;

use App\Data\Role\StoreRoleActionData;
use App\Http\Controllers\Controller;
use App\Logics\Roles\RoleActionStoreLogic;
use Illuminate\Http\JsonResponse;

class RoleActionController extends Controller
{
    public function store(StoreRoleActionData $data, RoleActionStoreLogic $logic): JsonResponse
    {
        return $logic->run($data);
    }
}
