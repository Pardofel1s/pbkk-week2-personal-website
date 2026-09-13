<?php

namespace Tests\Feature;

use Tests\TestCase;

class EncodingTest extends TestCase
{
    public function test_pages_have_clean_text_and_verified_profile(): void
    {
        foreach (['/', '/mahasiswa/5025241153', '/agent', '/dashboard'] as $url) {
            $this->get($url)->assertOk()->assertDontSee('â†')->assertDontSee('Â·')->assertDontSee('â€™');
        }
        $this->get('/mahasiswa/5025241153')->assertSee('3.85')->assertSee('81 SKS')->assertSee('NCC ITS')->assertSee('SMA Negeri 1 Tuban');
    }
}
