<?php

namespace Database\Seeders;

use App\Models\SettingValueType;
use Illuminate\Database\Seeder;

class SettingValueTypeSeeder extends Seeder
{
    public function run(): void
    {
        SettingValueType::upsert([
            [
                'id' => '30C19D20-466D-11F0-AD55-51073ABD5648',
                'name' => 'String',
            ],
            [
                'id' => '3B049120-466D-11F0-AD55-51073ABD5648',
                'name' => 'Integer',
            ],
            [
                'id' => '47053AB0-466D-11F0-AD55-51073ABD5648',
                'name' => 'Boolean',
            ],
            [
                'id' => '55C83890-466D-11F0-AD55-51073ABD5648',
                'name' => 'Json',
            ],
        ], ['id'], ['name']);
    }
}
