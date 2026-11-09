<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DepartemenFactory extends Factory
{
    public function definition(): array
    {
        return ['nama' => 'Departemen ' . fake()->unique()->lastName()];
    }
}
