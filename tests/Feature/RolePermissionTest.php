<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolePermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_admin_holds_the_delete_permission(): void
    {
        $this->seed(RoleAndPermissionSeeder::class);

        $admin = User::factory()->create()->assignRole('admin');
        $staf = User::factory()->create()->assignRole('staf');

        $this->assertTrue($admin->can('hapus-mahasiswa'));
        $this->assertFalse($staf->can('hapus-mahasiswa'));
        $this->assertTrue($staf->can('kelola-mahasiswa'));
    }

    public function test_seeder_can_run_twice(): void
    {
        $this->seed(RoleAndPermissionSeeder::class);
        $this->seed(RoleAndPermissionSeeder::class);

        $this->assertDatabaseCount('roles', 2);
        $this->assertDatabaseCount('permissions', 3);
    }
}
