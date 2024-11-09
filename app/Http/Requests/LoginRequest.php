<?php

namespace App\Http\Requests;


class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|exists:users,email|email:rfc',
            'password' => 'required|string',
        ];
    }
}
