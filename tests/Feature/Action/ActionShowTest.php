<?php

namespace Tests\Feature\Action;

use App\Models\Action;
use Tests\TestCase;

class ActionShowTest extends TestCase
{
    public function test_show_action_retorna_codigo_200()
    {
        $this->loginRoot();

        $action = Action::factory()->create();

        $response = $this->getJson("/api/v1/actions/{$action->id}");

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
                'name' => $action->name,
                'description' => $action->description,
            ],
        ]);
    }

    public function test_without_action()
    {
        $this->loginAdmin()->attachAction(['auth.flow.show']);

        $action = Action::factory()->create();

        $response = $this->getJson("/api/v1/actions/{$action->id}");

        $response->assertStatus(403);

        $response->assertJson([
            'status' => 'error',
            'message' => __('You do not have permission to access this resource'),
            'data' => [
                'action' => 'auth.action.show',
            ],
        ]);
    }
}
