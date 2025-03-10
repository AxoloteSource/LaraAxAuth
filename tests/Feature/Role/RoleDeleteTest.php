<?php

namespace Tests\Feature\Role;

use App\Models\Role;
use Tests\TestCase;

class RoleDeleteTest extends TestCase
{
    public function test_delete_role_retorna_codigo_204()
    {
        $this->loginRoot();

        $role = Role::factory()->create();

        $response = $this->deleteJson("/api/v1/roles/{$role->id}");

        $response->assertStatus(204);

        $this->assertDatabaseHas('roles', ['id' => $role->id, 'deleted_at' => now()]);
    }
}
