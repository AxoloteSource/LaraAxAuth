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
                    'user' => [
                        'id' => $user->id,
                        'role_id' => $user->role_id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'email_verified_at' => $user->email_verified_at->toJSON(),
                        'remember_token' => $user->remember_token,
                        'deleted_at' => $user->deleted_at,
                        'created_at' => $user->created_at->toJSON(),
                        'updated_at' => $user->updated_at->toJSON(),
                        'role' => $user->role->toArray(),
                    ],
                ],
            ]);
    }
}
