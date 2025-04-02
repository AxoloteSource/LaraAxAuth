<?php

namespace App\Data\Auth;

use App\Enums\RoleEnum;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class RegisterData extends Data
{
    public function __construct(
        #[Rule('required|string|max:50|min:3')]
        public string $name,
        #[Rule('required|email|string|unique:users')]
        public string $email,
        #[Rule(['required', 'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*()]{8,}$/', 'confirmed'])]
        public string $password,
        public ?string $role_id = null,
    ) {
        $this->role_id ??= RoleEnum::Admin->value;
        $this->password = bcrypt($this->password);
    }
}
