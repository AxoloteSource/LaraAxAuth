<?php

namespace App\Data\Auth;

use App\Constants\AuthMessages;
use Illuminate\Validation\ValidationException;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class LoginData extends Data
{
    public function __construct(
        #[Rule(['required', 'exists:users,email', 'email:rfc'])]
        public string $email,
        #[Rule(['required'])]
        public string $password,
    ) {
    }

    /**
     * Override validate to throw generic error message
     */
    public static function validate(\Illuminate\Contracts\Support\Arrayable|array $payload): \Illuminate\Contracts\Support\Arrayable|array
    {
        try {
            return parent::validate($payload);
        } catch (ValidationException $e) {
            throw ValidationException::withMessages([
                'password' => __(AuthMessages::INVALID_CREDENTIALS),
            ]);
        }
    }
}
