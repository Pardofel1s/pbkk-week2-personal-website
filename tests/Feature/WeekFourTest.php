<?php

namespace Tests\Feature;

use App\Http\Controllers\PageController;
use Tests\TestCase;

class WeekFourTest extends TestCase
{
    public function test_required_pages_use_the_named_page_controller_routes_and_shared_layout(): void
    {
        $pages = [
            ['home', '/', 'PageController@index'],
            ['profile', '/profil-mahasiswa', 'PageController@profile'],
            ['agent.idea', '/ide-agent', 'PageController@agent'],
        ];

        foreach ($pages as [$routeName, $path, $action]) {
            $route = app('router')->getRoutes()->getByName($routeName);

            $this->assertNotNull($route);
            $this->assertSame(PageController::class.'@'.substr($action, strlen('PageController@')), $route->getActionName());

            $response = $this->get($path);
            $response->assertOk()->assertSee('Navigasi utama');
            $this->assertSame(1, substr_count($response->getContent(), '<!DOCTYPE html>'));
        }

        $this->get('/profil-mahasiswa')->assertSee('info-card', false);
        $this->get('/ide-agent')->assertSee('status-banner', false)->assertSee('idea-message', false);
    }

    public function test_dynamic_dark_route_uses_blade_tailwind_classes_and_name_greeting_uses_status_slot(): void
    {
        $this->get('/ide-agent?mode=dark')
            ->assertOk()
            ->assertSee('!bg-[#211c19]', false);

        $this->get('/beranda?user=Andi')
            ->assertOk()
            ->assertSee('Selamat datang, Andi.')
            ->assertSee('status-banner--success', false);
    }

    public function test_idea_form_validates_and_returns_a_session_receipt(): void
    {
        $idea = 'Tambahkan ringkasan alasan dan bukti untuk setiap temuan agent.';

        $response = $this->from('/ide-agent/dast?mode=dark')->post(route('agent.idea.submit'), [
            'name' => 'Andi',
            'idea' => $idea,
            'tema' => 'dast',
            'mode' => 'dark',
        ]);

        $response->assertRedirect('/ide-agent/dast?mode=dark')
            ->assertSessionHas('ideaSubmission', ['name' => 'Andi', 'idea' => $idea]);

        $this->get('/ide-agent/dast?mode=dark')
            ->assertOk()
            ->assertSee('Terima kasih, Andi.')
            ->assertSee($idea)
            ->assertSee('!bg-[#211c19]', false);
    }

    public function test_idea_form_reports_validation_errors_and_preserves_the_form_page(): void
    {
        $this->from('/ide-agent')->post(route('agent.idea.submit'), [
            'name' => '',
            'idea' => 'Terlalu singkat',
        ])->assertRedirect('/ide-agent')->assertSessionHasErrors(['name', 'idea']);
    }
}
