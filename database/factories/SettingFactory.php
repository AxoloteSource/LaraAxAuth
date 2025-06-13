<?php

namespace Database\Factories;

use App\Models\Setting;
use App\Models\SettingValueType;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    protected $model = Setting::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'name' => $this->faker->name(),
            'value' => $this->faker->text(),
            'setting_value_type_id' => SettingValueType::inRandomOrder()->first()->id,
            'encrypted' => $this->faker->boolean(),
            'is_public' => $this->faker->boolean(),
            'group' => $this->faker->name(),
        ];
    }
}
