<?php

namespace App\Http\Resources\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class LoginResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user' => $this->resource,
            'access_token' => $this->createToken('access_token')->accessToken,
        ];
    }
}
