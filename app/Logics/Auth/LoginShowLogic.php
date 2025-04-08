<?php

namespace App\Logics\Auth;

use App\Core\Logics\ShowLogic;
use App\Data\Auth\LoginData;
use App\Http\Resources\Auth\LoginResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\LaravelData\Data;

class LoginShowLogic extends ShowLogic
{
    protected Data|LoginData $input;

    public function __construct(protected User $user)
    {
        parent::__construct($user);
    }

    public function run(LoginData|Data $input): JsonResponse
    {
        return parent::logic($input);
    }

    protected function before(): bool
    {
        if (! $this->validCredentials()) {
            return false;
        }

        return true;
    }

    protected function makeQuery(): Builder
    {
        return User::where('email', $this->input->email);
    }

    protected function withResource(): array|Model|JsonResource
    {
        return new LoginResource($this->response);
    }

    public function validCredentials(): bool
    {
        if (auth()->attempt(['email' => $this->input->email, 'password' => $this->input->password])) {
            return true;
        }

        return $this->error('Invalid credentials');
    }
}
