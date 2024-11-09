<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\FormRequest;

/**
 * @property string email
 * @property string password
 * @property string password_confirmation
 * @property string name
 */
class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50|min:3',
            'email' => 'required|email|string|unique:users',
            'password' => 'required|min:8|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*()]{8,}$/|confirmed',
            'password_confirmation' => 'required_with:password|same:password',
        ];
    }
}