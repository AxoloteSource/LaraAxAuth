<?php

namespace App\Http\Controllers;

use App\Data\Auth\LoginData;
use App\Data\Auth\RegisterData;
use App\Logics\Auth\LoginShowLogic;
use App\Logics\Auth\RegisterStoreLogic;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

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

    public function logout()
    {
        $user = auth()->user()->logout();

        return $user ? Response::success(null, __('Successfully logged out.')) : Response::error(__('Failed to logout.'), null);
    }
}
