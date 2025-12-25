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
                'description' => 'Super administrator with unrestricted access to all system features and actions',
            ],
            [
                'id' => RoleEnum::Admin->value,
                'name' => 'Admin',
                'key' => 'admin',
                'description' => 'Administrator with access to manage system, settings and users',
            ],
            [
                'id' => RoleEnum::Messages->value,
                'name' => 'Messages',
                'key' => 'messages',
                'description' => 'User has total access to messages',
            ],
        ], ['id'], ['name', 'description']);
    }
}
