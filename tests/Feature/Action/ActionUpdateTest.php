<?php

namespace Tests\Feature\Action;

use App\Models\Action;
use Tests\TestCase;

class ActionUpdateTest extends TestCase
{
    public function test_update_action_retorna_codigo_200()
    {
        $this->loginRoot();

        $action = Action::factory()->create();

        $payload = [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
        ];

        $response = $this->putJson("/api/v1/actions/{$action->id}", $payload);

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
                'id' => $action->id,
                'name' => $payload['name'],
                'description' => $payload['description'],
            ],
        ]);

        $this->assertDatabaseHas('actions', [
            'id' => $action->id,
            'name' => $payload['name'],
            'description' => $payload['description'],
        ]);
    }

    public function test_without_action()
    {
        $this->loginAdmin()->attachAction(['auth.flow.update']);
        $action = Action::factory()->create();

        $payload = [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
        ];

        $response = $this->putJson("/api/v1/actions/{$action->id}", $payload);

        $response->assertStatus(403);

        $response->assertJson([
            'status' => 'error',
            'message' => __('You do not have permission to access this resource'),
            'data' => [
                'action' => 'auth.action.update',
            ],
        ]);
    }
}
