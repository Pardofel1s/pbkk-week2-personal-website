<?php

namespace Database\Factories;

use App\Models\Departemen;
use Illuminate\Database\Eloquent\Factories\Factory;

class MahasiswaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nrp' => fake()->unique()->numerify('5025######'),
            'nama' => fake('id_ID')->name(),
            'departemen_id' => Departemen::factory(),
            'angkatan' => fake()->numberBetween(2021, 2025),
            'is_active' => fake()->boolean(85),
        ];
    }
}
