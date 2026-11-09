<?php

namespace Database\Seeders;

use App\Models\Departemen;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleAndPermissionSeeder::class);

        $accounts = [
            ['Admin Demo', 'admin@portal.test', 'admin'],
            ['Staf Demo', 'staf@portal.test', 'staf'],
            ['Pengguna Biasa', 'user@portal.test', null],
        ];

        foreach ($accounts as [$name, $email, $role]) {
            $user = User::factory()->create(['name' => $name, 'email' => $email]);

            if ($role) {
                $user->assignRole($role);
            }
        }

        $departemens = collect(['Teknik Informatika', 'Sistem Informasi', 'Teknologi Informasi', 'Teknik Elektro', 'Teknik Komputer'])
            ->map(fn (string $nama) => Departemen::create(['nama' => $nama]));

        Mahasiswa::factory()->count(60)->sequence(fn () => ['departemen_id' => $departemens->random()->id])->create();
        Dosen::factory()->count(20)->sequence(fn () => ['departemen_id' => $departemens->random()->id])->create();
        Tugas::factory()->count(30)->sequence(fn () => ['departemen_id' => $departemens->random()->id])->create();
    }
}
