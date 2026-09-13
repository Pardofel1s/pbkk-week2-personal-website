<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    #[DataProvider('pageCases')]
    public function test_pages_render_with_navigation(string $path, string $content): void
    {
        $this->get($path)->assertOk()->assertSee($content)->assertSee('Navigasi utama');
    }

    public static function pageCases(): array
    {
        return [
            ['/', '5025241153'],
            ['/about', 'Departemen Teknik Informatika'],
            ['/project-idea', 'Usulan awal'],
            ['/projects', 'Kalkulator dinamis'],
            ['/contact', 'nonamexz1728@gmail.com'],
            ['/collection', 'Playfair Display'],
            ['/blog', 'Satu URL, tiga bagian'],
            ['/blog/route-controller-dan-view', 'Controller menyiapkan respons'],
            ['/kalkulator', 'Angka pertama'],
        ];
    }

    #[DataProvider('calculationCases')]
    public function test_calculations_return_expected_results(string $path, string $sentence): void
    {
        $this->get($path)->assertOk()->assertSee($sentence);
    }

    public static function calculationCases(): array
    {
        return [
            ['/hitung/10/5/tambah', 'Hasil dari 10 tambah 5 adalah 15'],
            ['/hitung/10/5/kurang', 'Hasil dari 10 kurang 5 adalah 5'],
            ['/hitung/10/5/kali', 'Hasil dari 10 kali 5 adalah 50'],
            ['/hitung/10/5/bagi', 'Hasil dari 10 bagi 5 adalah 2'],
            ['/hitung/-2.5/4/kali', 'Hasil dari -2.5 kali 4 adalah -10'],
            ['/hitung/0.1/0.2/tambah', 'Hasil dari 0.1 tambah 0.2 adalah 0.3'],
            ['/hitung/0/5/bagi', 'Hasil dari 0 bagi 5 adalah 0'],
        ];
    }

    #[DataProvider('invalidCases')]
    public function test_invalid_calculations_show_helpful_errors(string $path, string $message): void
    {
        $this->get($path)->assertStatus(422)->assertSee($message)->assertSee('Angka pertama');
    }

    public static function invalidCases(): array
    {
        return [
            ['/hitung/10/0/bagi', 'Angka tidak dapat dibagi dengan nol'],
            ['/hitung/10/-0/bagi', 'Angka tidak dapat dibagi dengan nol'],
            ['/hitung/abc/5/kali', 'Masukkan dua angka yang valid'],
            ['/hitung/1e309/1/tambah', 'Masukkan dua angka yang valid'],
            ['/hitung/1000000000001/1/tambah', 'Gunakan angka antara'],
            ['/hitung/10/5/pangkat', 'Pilih operasi tambah'],
        ];
    }

    public function test_form_redirects_to_required_calculation_route(): void
    {
        $this->get('/kalkulator/submit?angka1=-2.5&angka2=4&operasi=kali')
            ->assertRedirect('/hitung/-2.5/4/kali');
    }

    public function test_incomplete_form_returns_validation_errors(): void
    {
        $this->from('/kalkulator')->get('/kalkulator/submit?angka1=4')
            ->assertRedirect('/kalkulator')->assertSessionHasErrors(['angka2', 'operasi']);
    }

    public function test_unknown_article_and_page_have_a_useful_404(): void
    {
        $this->get('/blog/tidak-ada')->assertNotFound()->assertSee('Back to Home');
        $this->get('/halaman-tidak-ada')->assertNotFound()->assertSee('Back to Home');
    }

    public function test_profile_text_is_escaped_in_blade(): void
    {
        config(['portfolio.name' => '<script>alert(1)</script>']);
        $this->get('/')->assertOk()->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_every_application_route_delegates_to_page_controller(): void
    {
        $routes = ['home', 'about', 'project', 'projects', 'contact', 'collection', 'blog', 'article', 'calculator', 'calculator.submit', 'calculate'];
        foreach ($routes as $name) {
            $route = app('router')->getRoutes()->getByName($name);
            $this->assertStringStartsWith('App\\Http\\Controllers\\PageController@', $route->getActionName());
        }
    }
}
