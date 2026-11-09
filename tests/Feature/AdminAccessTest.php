<?php

namespace Tests\Feature;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Tugas;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleAndPermissionSeeder::class);
    }

    public function test_guest_is_sent_to_login(): void
    {
        $this->get('/admin/dashboard')->assertRedirect('/login');
    }

    public function test_user_without_role_gets_403_and_lands_on_public_home(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin/dashboard')->assertForbidden();
        $this->post('/logout');

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect(route('home'));
    }

    public function test_unverified_admin_is_sent_to_verification_notice(): void
    {
        $admin = User::factory()->unverified()->create()->assignRole('admin');

        $this->actingAs($admin)->get('/admin/dashboard')->assertRedirect(route('verification.notice'));
    }

    public function test_admin_and_staf_land_on_the_dashboard_after_login(): void
    {
        foreach (['admin', 'staf'] as $role) {
            $user = User::factory()->create()->assignRole($role);

            $this->post('/login', ['email' => $user->email, 'password' => 'password'])
                ->assertRedirect(route('admin.dashboard'));
            $this->post('/logout');
        }
    }

    public function test_widgets_show_counts_from_the_database(): void
    {
        Mahasiswa::factory()->count(3)->create(['is_active' => true]);
        Mahasiswa::factory()->create(['is_active' => false]);
        Dosen::factory()->count(2)->create();
        Tugas::factory()->count(4)->create(['tenggat' => now()->addWeek()]);
        Tugas::factory()->create(['tenggat' => now()->subWeek()]);

        $this->actingAs(User::factory()->create()->assignRole('staf'))
            ->get('/admin/dashboard')
            ->assertOk()
            ->assertViewHas(['totalMahasiswa' => 3, 'totalDosen' => 2, 'totalTugasAktif' => 4])
            ->assertSee('Total Tugas Aktif');
    }
}
