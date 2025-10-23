<?php

namespace Tests\Feature\ActionRole;

use App\Models\Action;
use App\Models\Role;
use Tests\TestCase;

class ActionRoleIndexTest extends TestCase
{
    public function test_action_role_index(): void
    {
        $this->loginAdmin()->attachAction(['auth.role.actions.index']);
        $action = Action::factory()->create();
        $role = Role::factory()->create();
        $role->actions()->attach($action);
        $response = $this->get("/api/v1/roles/{$role->id}/actions");
        $response->assertStatus(206);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'deleted_at',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);

        $response->assertJsonFragment([
            'id' => (string) $action->id,
            'name' => $action->name,
            'description' => $action->description,
        ]);
    }

    public function test_action_role_index_returns_empty_when_no_actions(): void
    {
        $this->loginAdmin()->attachAction(['auth.role.actions.index']);
        $role = Role::factory()->create();
        Action::factory()->count(10)->create();
        $response = $this->get("/api/v1/roles/{$role->id}/actions");
        $response->assertStatus(206);
        $response->assertJsonStructure([
            'data',
            'current_page',
            'per_page',
            'total',
        ]);
        $response->assertJsonCount(0, 'data');
        $response->assertJson(['total' => 0]);
    }

    public function test_action_role_index_validate_total(): void
    {
        $this->loginAdmin()->attachAction(['auth.role.actions.index']);
        $role = Role::factory()->create();
        $action = Action::factory()->create();
        $role->actions()->attach($action);
        $response = $this->get("/api/v1/roles/{$role->id}/actions");
        $response->assertStatus(206);
        $response->assertJsonStructure([
            'data',
            'current_page',
            'per_page',
            'total',
        ]);
        $response->assertJsonCount(1, 'data');
        $response->assertJson([
            'total' => 1,
        ]);
    }
}
