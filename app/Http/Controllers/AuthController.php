<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use App\Models\User;


class AuthController extends Controller
{
    /*public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::store(
            firstName: $request->first_name,
            lastName: $request->last_name,
            email: $request->email,
            password: $request->password,
            nickname: $request->nickname,
            phoneCodeIso2: $request->phone_code,
            phoneNumber: $request->phone_number,
            referralNickName: $request->referral_nickname
        );
        return Response::success(
            [
                'user' => $user,
                'access_token' => $user->createToken('access_token')->plainTextToken,
            ]);
    }*/

    /*public function login(LoginRequest $request): JsonResponse
    {
        $response = User::login(
            email : $request->email,
            password : $request->password
        );
        return $response ? Response::success($response) : Response::error(__("Credenciales no validas."));
    }*/
}
