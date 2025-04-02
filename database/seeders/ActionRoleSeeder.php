<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\ActionRole;
use Illuminate\Database\Seeder;

class ActionRoleSeeder extends Seeder
{
    public function run(): void
    {
        ActionRole::upsert([
            [
                'id' => 1,
                'action_id' => '0195f51f-cdd1-7256-b489-a2d5de9580d4',
                'role_id' => RoleEnum::Admin->value,
            ],
        ], ['id'], ['action_id', 'role_id']);
    }
}
