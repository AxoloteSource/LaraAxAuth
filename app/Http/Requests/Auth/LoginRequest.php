<?php

namespace App\Http\Requests\Auth;


use App\Http\Requests\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => '',
            'password' => 'required|string',
        ];
    }
}
