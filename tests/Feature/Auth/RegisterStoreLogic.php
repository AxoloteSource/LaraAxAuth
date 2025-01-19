<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class RegisterStoreLogic extends TestCase
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

        // Extrae datos de la respuesta
        $responseData = $response->json('data');
        $userData = $responseData['user'];

        // Verifica contenido específico
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

        // Verifica que se haya creado el usuario en la base de datos
        $this->assertDatabaseHas('users', [
            'id' => $userData['id'],
            'name' => $name,
            'email' => $email,
        ]);

        // Verifica que el access_token exista
        $this->assertArrayHasKey('access_token', $responseData, 'El token de acceso no está presente en la respuesta');

    }
}
