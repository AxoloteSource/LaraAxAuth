<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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
                'name' => 'Customer',
                'description' => 'User customer',
            ],
        ], ['id'], ['name', 'description']);
    }
}
