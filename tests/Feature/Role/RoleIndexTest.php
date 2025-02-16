<?php

namespace Tests\Feature\Role;

use App\Models\Role;
use Tests\TestCase;

class RoleIndexTest extends TestCase
{
    public function test_index_roles_con_busqueda_root_retorna_codigo_206()
    {
        $this->loginRoot();

        $response = $this->getJson('/api/v1/roles?search=Root');

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
            'name' => 'Root',
            'description' => 'User root',
        ]);

        $response->assertJsonCount(1, 'data');
    }

    public function test_index_roles_sin_busqueda_con_roles_adicionales_retorna_codigo_206()
    {
        $this->loginRoot();

        Role::factory()->count(15)->create();

        $response = $this->getJson('/api/v1/roles?limit=10');

        $response->assertStatus(206);

        $response->assertJsonCount(10, 'data');

        $rolesCreados = Role::latest()->take(10)->get();

        //dd($response->json());

        foreach ($rolesCreados as $rol) {
            $response->assertJsonFragment([
                'id' => $rol->id,
                'name' => $rol->name,
                'description' => $rol->description,
            ]);
        }
    }

}
