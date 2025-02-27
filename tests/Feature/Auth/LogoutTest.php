<?php

namespace Tests\Feature\Auth;

use App\Enums\RoleEnum;
use App\Models\User;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function test_logout_retorna_codigo_200()
    {
        $user = User::factory()->create(['role_id' => RoleEnum::Root->value]);
        $accessToken = $user->createToken('access_token');

        $this->withHeaders([
            'Authorization' => 'Bearer '.$accessToken->accessToken,
        ]);

        $response = $this->postJson('/api/v1/logout');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            'message',
        ]);

        $response->assertJson([
            'status' => 'OK',
            'message' => null,
            'data' => null,
        ]);

        $this->assertDatabaseHas('oauth_access_tokens', [
            'id' => $accessToken->token->id,
            'revoked' => true,
        ]);
    }
}
