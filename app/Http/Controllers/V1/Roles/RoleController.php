<?php

namespace App\Http\Controllers\V1\Roles;

use App\Core\Data\IndexData;
use App\Http\Controllers\Controller;
use App\Logics\Roles\RoleIndexLogic;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
  public function index(IndexData $data, RoleIndexLogic $logic): JsonResponse
  {
    return $logic->run($data);
  }
}
