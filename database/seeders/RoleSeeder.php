<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::upsert([
            [
                'id' => RoleEnum::Root->value,
                'name' => 'Root',
                'key' => 'root',
                'description' => 'User root',
            ],
            [
                'id' => RoleEnum::Admin->value,
                'name' => 'Admin',
                'key' => 'admin',
                'description' => 'User admin',
            ],
        ], ['id'], ['name', 'description']);
    }
}
