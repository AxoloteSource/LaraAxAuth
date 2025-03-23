<?php

namespace App\Http\Controllers;

use App\Data\Auth\IsAllowedData;
use App\Data\Auth\LoginData;
use App\Data\Auth\RegisterData;
use App\Logics\Auth\IsAllowedLogic;
use App\Logics\Auth\LoginShowLogic;
use App\Logics\Auth\LogoutLogic;
use App\Logics\Auth\MeLogic;
use App\Logics\Auth\RegisterStoreLogic;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function register(RegisterData $data, RegisterStoreLogic $logic): JsonResponse
    {
        return $logic->run($data);
    }

    public function login(LoginData $data, LoginShowLogic $logic): JsonResponse
    {
        return $logic->run($data);
    }

    public function logout(LogoutLogic $logic): JsonResponse
    {
        return $logic->run();
    }

    public function isAllowed(IsAllowedData $data, IsAllowedLogic $logic): JsonResponse
    {
        return $logic->run($data);
    }

    public function me(MeLogic $logic): JsonResponse
    {
        return $logic->run();
    }
}
