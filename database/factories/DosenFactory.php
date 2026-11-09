<?php

namespace Database\Factories;

use App\Models\Departemen;
use Illuminate\Database\Eloquent\Factories\Factory;

class DosenFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nip' => fake()->unique()->numerify('19##########0#####'),
            'nama' => fake('id_ID')->name(),
            'departemen_id' => Departemen::factory(),
        ];
    }
}
