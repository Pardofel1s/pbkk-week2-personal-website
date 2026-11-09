<?php

namespace Tests\Feature;

use App\Models\Departemen;
use App\Models\Dosen;
use App\Models\Tugas;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadOnlyModulesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleAndPermissionSeeder::class);
        $this->actingAs(User::factory()->create()->assignRole('staf'));
    }

    public function test_dosen_search_matches_name_or_nip(): void
    {
        Dosen::factory()->create(['nama' => 'Prof Anwar', 'nip' => '198001012005011001']);
        Dosen::factory()->create(['nama' => 'Dr Bunga', 'nip' => '198502022010122002']);

        $this->get('/admin/dosen?search=Anwar')->assertSee('Prof Anwar')->assertDontSee('Dr Bunga');
        $this->get('/admin/dosen?search=198502022010122002')->assertSee('Dr Bunga')->assertDontSee('Prof Anwar');
    }

    public function test_tugas_filters_by_title_and_departemen_and_keeps_them_in_pagination(): void
    {
        $departemen = Departemen::factory()->create();
        Tugas::factory()->count(12)->create(['judul' => 'Tugas Grafika', 'departemen_id' => $departemen->id]);
        Tugas::factory()->create(['judul' => 'Tugas Jaringan']);

        $this->get('/admin/tugas?search=Jaringan')->assertSee('Tugas Jaringan')->assertDontSee('Tugas Grafika');

        $page = $this->get("/admin/tugas?departemen_id={$departemen->id}")->assertDontSee('Tugas Jaringan')->viewData('tugas');
        $this->assertStringContainsString("departemen_id={$departemen->id}", $page->url(2));
    }

    public function test_user_without_role_is_forbidden(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/admin/dosen')->assertForbidden();
        $this->get('/admin/tugas')->assertForbidden();
    }
}
