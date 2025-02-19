<?php

namespace Tests\Feature\Auth;

use App\Enums\RoleEnum;
use Tests\TestCase;

class RegisterStoreLogicTest extends TestCase
{
    public function test_can_register(): void
    {
        $faker = $this->faker;
        $name = $faker->firstName;
        $email = $faker->unique()->safeEmail;
        $password = '$Password123';

        $payload = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $response = $this->postJson('api/v1/register', $payload);

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
                    'name' => $name,
                    'email' => $email,
                ],
            ],
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $userData['id'],
            'name' => $name,
            'email' => $email,
            'role_id' => RoleEnum::Admin,
        ]);

        $this->assertArrayHasKey('access_token', $responseData, 'El token de acceso no está presente en la respuesta');

    }
}
