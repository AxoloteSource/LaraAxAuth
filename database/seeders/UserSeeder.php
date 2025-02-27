<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::upsert([
            [
                'id' => 1,
                'role_id' => RoleEnum::Root->value,
                'name' => env('ROOT_USER_NAME'),
                'email' => env('ROOT_USER_EMAIL'),
                'password' => bcrypt(env('ROOT_USER_PASSWORD')),
            ],
        ], ['id'], ['name', 'role_id', 'email', 'password']);
    }
}
