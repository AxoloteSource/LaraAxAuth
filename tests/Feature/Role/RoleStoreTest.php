<?php

namespace Tests\Feature\Role;

use Tests\TestCase;

class RoleStoreTest extends TestCase
{
    public function test_create_role_retorna_codigo_201()
    {
        $this->loginRoot();

        $payload = [
            'name' => $this->faker->unique()->name,
            'description' => $this->faker->text,
            'key' => $this->faker->unique()->word,
        ];

        $response = $this->postJson('/api/v1/roles', $payload);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'id',
                'name',
                'description',
                'created_at',
                'updated_at',
            ],
        ]);

        $response->assertJson([
            'status' => 'OK',
            'message' => null,
            'data' => [
                'name' => $payload['name'],
                'description' => $payload['description'],
            ],
        ]);

        $this->assertDatabaseHas('roles', [
            'id' => $response->json('data.id'),
            'description' => $payload['description'],
            'name' => $payload['name'],
        ]);
    }

    public function test_without_action()
    {
        $this->loginAdmin()->attachAction(['auth.flow.store']);

        $payload = [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
        ];

        $response = $this->postJson('/api/v1/roles', $payload);

        $response->assertStatus(403);

        $response->assertJson([
            'status' => 'error',
            'message' => 'You do not have permission to access this resource',
            'data' => [
                'action' => 'auth.role.store',
            ],
        ]);
    }
}
