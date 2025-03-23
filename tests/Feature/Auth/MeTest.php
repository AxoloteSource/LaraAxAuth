<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class MeTest extends TestCase
{
    public function test_can_me()
    {
        $user = $this->loginRoot();
        $response = $this->postJson('/api/v1/me');
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'OK',
                'message' => null,
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role_name' => $user->role->name,
                ],
            ]);
    }
}
