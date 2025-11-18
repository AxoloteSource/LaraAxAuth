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
                    'active',
                    'deleted_at',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);

        $data = $response->json('data');
        $match = collect($data)->firstWhere('id', $action->id);
        $this->assertTrue($match['active']);
    }

    public function test_assigned_actions(): void
    {
        $this->loginAdmin()->attachAction(['auth.role.actions.index']);
        $role = Role::factory()->create();
        $assignedActions = Action::factory()->count(2)->create();
        $unassignedActions = Action::factory()->count(2)->create();

        $role->actions()->attach($assignedActions->pluck('id'));
        $response = $this->get("/api/v1/roles/{$role->id}/actions");
        $response->assertStatus(206);

        $data = $response->json('data');
        foreach ($assignedActions as $action) {
            $match = collect($data)->firstWhere('id', $action->id);
            $this->assertTrue($match['active']);
        }

        foreach ($unassignedActions as $action) {
            $match = collect($data)->firstWhere('id', $action->id);
            $this->assertFalse($match['active']);
        }
    }

    public function test_unassigned_actions(): void
    {
        $this->loginAdmin()->attachAction(['auth.role.actions.index']);
        $role = Role::factory()->create();
        Action::factory()->count(10)->create();
        $response = $this->get("/api/v1/roles/{$role->id}/actions");
        $response->assertStatus(206);
        $data = $response->json('data');
        foreach ($data as $action) {
            $this->assertFalse($action['active']);
        }
    }
}
