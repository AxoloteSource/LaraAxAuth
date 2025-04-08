<?php

namespace Tests\Feature\Role;

use App\Models\Role;
use Tests\TestCase;

class RoleUpdateTest extends TestCase
{
    public function test_update_role_retorna_codigo_200()
    {
        $this->loginRoot();

        $role = Role::factory()->create();

        $payload = [
            'name' => 'NuevoNombre',
            'description' => 'NuevaDescripción',
        ];

        $response = $this->putJson("/api/v1/roles/{$role->id}", $payload);

        $response->assertStatus(200);

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
                'id' => $role->id,
                'name' => 'NuevoNombre',
                'description' => 'NuevaDescripción',
            ],
        ]);

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => 'NuevoNombre',
            'description' => 'NuevaDescripción',
        ]);
    }

    public function test_update_role_con_id_inexistente_retorna_codigo_400()
    {
        $this->withExceptionHandling();
        $this->loginRoot();

        $payload = [];

        $response = $this->putJson('/api/v1/roles/100', $payload);

        $response->assertStatus(400);

        $response->assertJsonStructure([
            'status',
            'message',
        ]);

        $response->assertJson([
            'status' => 'error',
            'message' => null,
            'data' => [
                'id' => ['The selected id is invalid.'],
                'description' => ['The description field is required.'],
                'name' => ['The name field is required.'],
            ],
        ]);
    }

    public function test_without_action()
    {
        $this->loginAdmin()->attachAction(['auth.flow.update']);
        $role = Role::factory()->create();

        $payload = [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
        ];

        $response = $this->putJson("/api/v1/roles/{$role->id}", $payload);

        $response->assertStatus(403);

        $response->assertJson([
            'status' => 'error',
            'message' => 'You do not have permission to access this resource',
            'data' => [
                'action' => 'auth.role.update',
            ],
        ]);
    }
}
