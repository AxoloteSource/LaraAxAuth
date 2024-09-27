<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:220|min:3',
            'last_name' => 'required|string|max:220|min:2',
            'phone_code' => 'exists:phone_codes,phone_code',
            'phone_number' => 'string|unique:users,phone_number|size:10',
            'email' => 'required|email|string|unique:users',
            'password' => 'required|min:8|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*()]{8,}$/|confirmed',
            'password_confirmation' => 'required_with:password|same:password',
            'nickname' =>  'required|string|min:5|unique:users,nickname|regex:/^[^\s]*$/',
            'referral_nickname' =>  'nullable|string|min:5',
        ];
    }

    public function attributes(): array
    {
        return [
            'first_name' => __('nombre'),
            'last_name' => __('apellidos'),
            'phone_code_id' => __('código pais'),
            'phone_number' => __('número teléfono'),
            'email' => __('correo'),
            'password' => __('contraseña'),
            'password_confirmation' => __('confirmación contraseña'),
            'nickname' =>  __('nombre usuario'),
            'referral_nickname' =>  __('código referido'),
        ];
    }
}
