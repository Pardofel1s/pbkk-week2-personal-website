<?php

namespace Tests\Feature;

use Tests\TestCase;

class AcademicTest extends TestCase
{
    public function test_profile_and_constraints(): void
    {
        $this->get('/mahasiswa/5025241153')->assertOk()->assertSee('Kamal Zaky Adinata');
        foreach (['abc', '123', '50252411530', '0000000000'] as $nrp) {
            $this->get('/mahasiswa/'.$nrp)->assertNotFound();
        }
        $this->get('/mahasiswa')->assertNotFound();
        $this->get('/dashboard/mahasiswa/5025241153')->assertOk();
    }

    public function test_optional_theme_and_dashboard(): void
    {
        $this->get('/agent')->assertOk()->assertSee('General Assistant Agent');
        $this->get('/agent/dast')->assertOk()->assertSee('DAST');
        $this->get('/agent/research')->assertOk()->assertSee('research');
        $this->get('/dashboard')->assertOk();
        $this->get('/dashboard/agent')->assertOk()->assertSee('General Assistant Agent');
        $this->get('/project-idea')->assertRedirect(route('agent', ['tema' => 'dast']));
        $this->get('/not-a-page')->assertNotFound()->assertSee('Back to Home');
    }

    public function test_gpa_and_invalid_inputs(): void
    {
        $this->get('/hitung-ipk/3.5/4')->assertOk()->assertSee('3.75');
        $this->get('/hitung-ipk/0/0')->assertOk()->assertSee('0.00');
        foreach (['abc', '-1', '4.1', '1e309'] as $ip) {
            $this->get('/hitung-ipk/'.$ip.'/3')->assertStatus(422);
        }
        $this->get('/dashboard/ipk')->assertOk();
        $this->get('/dashboard/ipk/submit?ip1=3.5&ip2=4')->assertRedirect(route('gpa.calculate', ['ip1' => '3.5', 'ip2' => '4']));
        $this->get('/dashboard/ipk/submit?ip1=5&ip2=3')->assertSessionHasErrors('ip1');
    }
}
