<?php

namespace Tests\Feature\Action;

use App\Models\Action;
use Tests\TestCase;

class ActionIndexTest extends TestCase
{
    public function test_index_actions_con_busqueda_retorna_codigo_200()
    {
        $this->loginRoot();

        $action = Action::factory()->create([
            'name' => $this->faker->name,
            'description' => $this->faker->text,
        ]);

        $response = $this->getJson("/api/v1/actions?search={$action->name}");

        $response->assertStatus(206);

        $response->assertJsonStructure([
            'current_page',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'created_at',
                    'updated_at',
                ],
            ],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'links' => [
                '*' => [
                    'url',
                    'label',
                    'active',
                ],
            ],
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
            'columns',
        ]);

        $response->assertJsonFragment([
            'id' => $action->id,
            'name' => $action->name,
            'description' => $action->description,
        ]);

        $response->assertJsonCount(1, 'data');
    }

    public function test_index_actions_sin_busqueda_con_actions_adicionales_retorna_codigo_200()
    {
        $this->loginRoot();

        Action::factory()->count(15)->create();

        $response = $this->getJson('/api/v1/actions?limit=10');

        $response->assertStatus(206);

        $response->assertJsonCount(10, 'data');

        $actionsCreadas = Action::take(10)->get();

        foreach ($actionsCreadas as $action) {
            $response->assertJsonFragment([
                'id' => $action->id,
                'name' => $action->name,
                'description' => $action->description,
            ]);
        }
    }
}
