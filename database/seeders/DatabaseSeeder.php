<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            ActionSeeder::class,
            UserSeeder::class,
            ActionRoleSeeder::class,
        ]);
    }
}
