<?php

namespace Tests\Feature\Role;

use App\Models\Role;
use Tests\TestCase;

class RoleShowTest extends TestCase
{
    public function test_show_role_retorna_codigo_200()
    {
        $this->loginRoot();

        $role = Role::factory()->create();

        $response = $this->getJson("/api/v1/roles/{$role->id}");

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
                'name' => $role->name,
                'description' => $role->description,
            ],
        ]);

    }
}
