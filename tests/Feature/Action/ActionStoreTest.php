<?php

namespace Tests\Feature\Action;

use Tests\TestCase;

class ActionStoreTest extends TestCase
{
    public function test_create_action()
    {
        $this->loginRoot();

        $payload = [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
        ];

        $response = $this->postJson('/api/v1/actions', $payload);

        $response->assertStatus(201);

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
                'name' => $payload['name'],
                'description' => $payload['description'],
            ],
        ]);

        $this->assertDatabaseHas('actions', [
            'id' => $response->json('data.id'),
            'name' => $payload['name'],
            'description' => $payload['description'],
        ]);
    }

    public function test_without_action()
    {
        $this->loginAdmin()->attachAction(['auth.flow.store']);

        $payload = [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
        ];

        $response = $this->postJson('/api/v1/actions', $payload);

        $response->assertStatus(403);

        $response->assertJson([
            'status' => 'error',
            'message' => __('You do not have permission to access this resource'),
            'data' => [
                'action' => 'auth.action.store',
            ],
        ]);
    }
}
