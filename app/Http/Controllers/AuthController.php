<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::register(
            $request->email,
            $request->name,
            $request->password
        );

        return Response::success(
            [
                'user' => $user,
                'access_token' => $user->createToken('access_token')->plainTextToken,
            ]
        );
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::login(
            $request->email,
            $request->password
        );

        return $user
            ? Response::success([
                'user' => $user,
                'access_token' => $user->createToken('access_token')->plainTextToken,
            ])
            : Response::error(__('Invalid credentials .'));
    }

    public function logout()
    {
        $userSesion = auth()->user()->logout();

        return $userSesion ? Response::success(null, __("Successfully logged out.")) : Response::error(__("Failed to logout."), null);
    }
    
}
