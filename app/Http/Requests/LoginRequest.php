<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "email" => "required|exists:users,email|email:rfc",
            "password" => "required|string"
        ];
    }

    public function attributes(): array
    {
        return [
            "email" => __("correo"),
            "password" => __("contraseña")
        ];
    }
}
