<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (['lihat-mahasiswa', 'kelola-mahasiswa', 'hapus-mahasiswa'] as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        Role::firstOrCreate(['name' => 'admin'])
            ->syncPermissions(['lihat-mahasiswa', 'kelola-mahasiswa', 'hapus-mahasiswa']);
        Role::firstOrCreate(['name' => 'staf'])
            ->syncPermissions(['lihat-mahasiswa', 'kelola-mahasiswa']);
    }
}
