<?php

namespace Tests\Feature;

use App\Models\Departemen;
use App\Models\Mahasiswa;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MahasiswaTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $staf;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleAndPermissionSeeder::class);
        $this->admin = User::factory()->create()->assignRole('admin');
        $this->staf = User::factory()->create()->assignRole('staf');
    }

    public function test_staf_cannot_see_or_execute_delete(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();

        $this->actingAs($this->staf)->get('/admin/mahasiswa')->assertOk()->assertDontSee('Hapus');
        $this->delete("/admin/mahasiswa/{$mahasiswa->id}")->assertForbidden();

        $this->assertModelExists($mahasiswa);
    }

    public function test_admin_can_delete(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();

        $this->actingAs($this->admin)->get('/admin/mahasiswa')->assertSee('Hapus');
        $this->delete("/admin/mahasiswa/{$mahasiswa->id}")->assertRedirect();

        $this->assertModelMissing($mahasiswa);
    }

    public function test_user_without_role_cannot_write(): void
    {
        $mahasiswa = Mahasiswa::factory()->create();

        $this->actingAs(User::factory()->create())
            ->delete("/admin/mahasiswa/{$mahasiswa->id}")
            ->assertForbidden();
    }

    public function test_staf_can_create_and_update(): void
    {
        $departemen = Departemen::factory()->create();
        $data = ['nrp' => '5025241153', 'nama' => 'Budi', 'departemen_id' => $departemen->id, 'angkatan' => 2024, 'is_active' => '1'];

        $this->actingAs($this->staf)->post('/admin/mahasiswa', $data)->assertRedirect('/admin/mahasiswa');
        $mahasiswa = Mahasiswa::firstWhere('nrp', '5025241153');
        $this->assertTrue($mahasiswa->is_active);

        // Unchecked checkbox is absent from the request; keeping its own NRP must not trip unique.
        unset($data['is_active']);
        $this->put("/admin/mahasiswa/{$mahasiswa->id}", ['nama' => 'Budi Baru'] + $data)->assertSessionHasNoErrors();

        $this->assertFalse($mahasiswa->fresh()->is_active);
        $this->assertSame('Budi Baru', $mahasiswa->fresh()->nama);
    }

    public function test_invalid_input_is_rejected(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/mahasiswa', ['nrp' => '123', 'nama' => '', 'departemen_id' => 999, 'angkatan' => 1])
            ->assertSessionHasErrors(['nrp', 'nama', 'departemen_id', 'angkatan']);

        $this->assertDatabaseCount('mahasiswas', 0);
    }

    public function test_search_matches_name_or_nrp_and_filters_combine(): void
    {
        $informatika = Departemen::factory()->create();
        Mahasiswa::factory()->create(['nama' => 'Ayu Lestari', 'nrp' => '5025000001', 'departemen_id' => $informatika->id, 'is_active' => true]);
        Mahasiswa::factory()->create(['nama' => 'Bima Sakti', 'nrp' => '5025000002', 'departemen_id' => $informatika->id, 'is_active' => false]);
        Mahasiswa::factory()->create(['nama' => 'Ayu Wulandari', 'nrp' => '5026000003', 'is_active' => true]);

        $this->actingAs($this->admin);

        $this->get('/admin/mahasiswa?search=Ayu')->assertSee('Ayu Lestari')->assertSee('Ayu Wulandari')->assertDontSee('Bima Sakti');
        $this->get('/admin/mahasiswa?search=5025000002')->assertSee('Bima Sakti')->assertDontSee('Ayu Lestari');
        $this->get("/admin/mahasiswa?search=Ayu&departemen_id={$informatika->id}")->assertSee('Ayu Lestari')->assertDontSee('Ayu Wulandari');
        $this->get('/admin/mahasiswa?status=0')->assertSee('Bima Sakti')->assertDontSee('Ayu Lestari');
        $this->get('/admin/mahasiswa?status=1')->assertSee('Ayu Lestari')->assertDontSee('Bima Sakti');
    }

    public function test_pagination_links_keep_the_active_filter(): void
    {
        Mahasiswa::factory()->count(12)->create(['nama' => 'Citra Dewi']);

        $page = $this->actingAs($this->admin)
            ->get('/admin/mahasiswa?search=Citra')
            ->assertOk()
            ->viewData('mahasiswas');

        $this->assertSame(2, $page->lastPage());
        $this->assertStringContainsString('search=Citra', $page->url(2));
    }

    public function test_array_filter_is_rejected_instead_of_crashing(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/mahasiswa?departemen_id[]=1')
            ->assertSessionHasErrors('departemen_id');
    }
}
