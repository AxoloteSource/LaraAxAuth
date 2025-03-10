<?php

namespace Tests\Feature\Action;

use App\Models\Action;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActionDeleteTest extends TestCase
{
    public function test_delete_role_retorna_codigo_204()
    {
        $this->loginRoot();

        $action = Action::factory()->create();

        $response = $this->deleteJson("/api/v1/actions/{$action->id}");

        $response->assertStatus(204);

        $this->assertDatabaseHas('actions', ['id' => $action->id, 'deleted_at' => now()]);

    }
}
