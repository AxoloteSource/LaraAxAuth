<?php

namespace Tests\Feature\Auth;

use App\Models\Action;
use App\Models\Role;
use Tests\TestCase;

class IsAllowedTest extends TestCase
{
    public function test_is_allowed_retorna_codigo_200()
    {
        $user = $this->loginAdmin();
        Action::factory()->create(['name' => 'user.not_assigned']);
        $user->role->actions()->attach(Action::factory()->create(['name' => 'user.allowed'])->id);

        $role = Role::factory()->create();
        $otherAction = Action::factory()->create(['name' => 'user.assigned_other_role']);
        $role->actions()->attach($otherAction->id);

        $payload = [
            'actions' => [
                'user.allowed',
                'user.not_assigned',
                'user.assigned_other_role',
                'user.not_exist',
            ],
        ];

        $response = $this->postJson('/api/v1/is-allowed', $payload);

        $response->assertStatus(200);

        $response->assertJson([
            'status' => 'OK',
            'message' => null,
            'data' => [
                'user.allowed' => true,
                'user.not_assigned' => false,
                'user.assigned_other_role' => false,
                'user.not_exist' => false,
            ],
        ]);
    }

    public function test_is_allowed_root_without_action()
    {
        $this->loginRoot();
        Action::factory()->create(['name' => 'user.allowed2']);

        $payload = [
            'actions' => [
                'user.allowed2',
                'user.not_exist2',
            ],
        ];

        $response = $this->postJson('/api/v1/is-allowed', $payload);

        $response->assertStatus(200);

        $response->assertJson([
            'status' => 'OK',
            'message' => null,
            'data' => [
                'user.allowed2' => true,
                'user.not_exist2' => true,
            ],
        ]);
    }
}
