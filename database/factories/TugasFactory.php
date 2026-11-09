<?php

namespace Database\Factories;

use App\Models\Departemen;
use Illuminate\Database\Eloquent\Factories\Factory;

class TugasFactory extends Factory
{
    public function definition(): array
    {
        return [
            'judul' => 'Tugas ' . fake()->randomElement(['Basis Data', 'Jaringan', 'Algoritma', 'Grafika', 'Keamanan', 'PBKK']) . ' ' . fake()->numberBetween(1, 12),
            'departemen_id' => Departemen::factory(),
            'tenggat' => fake()->dateTimeBetween('-1 month', '+2 months'),
        ];
    }
}
