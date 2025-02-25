<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::upsert([
            [
                'id' => 1,
                'name' => 'Root',
                'description' => 'User root',
            ],
            [
                'id' => 2,
                'name' => 'Admin',
                'description' => 'User admin',
            ],
        ], ['id'], ['name', 'description']);
    }
}
