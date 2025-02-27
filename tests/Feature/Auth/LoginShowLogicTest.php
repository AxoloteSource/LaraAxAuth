<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class LoginShowLogicTest extends TestCase
{
    public function test_can_login_with_valid_credentials()
    {
        $password = $this->faker->password;
        $user = User::factory()->create([
            'email' => $this->faker->email,
            'password' => bcrypt($password),
        ]);

        $loginData = [
            'email' => $user->email,
            'password' => $password,
        ];

        $response = $this->postJson('/api/v1/login', $loginData);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'user' => [
                    'id',
                    'name',
                    'email',
                    'role_id',
                    'created_at',
                    'updated_at',
                ],
                'access_token',
            ],
        ]);

        $responseData = $response->json('data');
        $userData = $responseData['user'];

        $response->assertJson([
            'status' => 'OK',
            'message' => null,
            'data' => [
                'user' => [
                    'email' => $user->email,
                ],
            ],
        ]);

        $this->assertEquals($user->id, $userData['id']);
        $this->assertEquals($user->email, $userData['email']);

        $this->assertArrayHasKey('access_token', $responseData, 'El token de acceso no está presente en la respuesta');
    }
}
