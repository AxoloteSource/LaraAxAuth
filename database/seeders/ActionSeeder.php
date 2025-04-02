<?php

namespace Database\Seeders;

use App\Models\Action;
use Illuminate\Database\Seeder;

class ActionSeeder extends Seeder
{
    public function run(): void
    {
        Action::upsert([
            [
                'id' => '0195f51f-cdd1-7256-b489-a2d5de9580d4',
                'name' => 'auth.role.attach.actions',
                'description' => 'Attach actions to role',
            ],
        ], ['id'], ['name', 'description']);

    }
}
