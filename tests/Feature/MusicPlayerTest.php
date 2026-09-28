<?php

namespace Tests\Feature;

use Tests\TestCase;

class MusicPlayerTest extends TestCase
{
    public function test_song_plays_through_an_in_page_soundcloud_widget(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Everything Goes On')
            ->assertSee('data-music-widget', false)
            ->assertSee('data-src="https://w.soundcloud.com/player/', false)
            ->assertSee('data-music-toggle', false)
            ->assertSee('data-music-seek', false)
            ->assertSee('data-music-status', false)
            ->assertSee('Buka panel, lalu tekan tombol putar untuk mulai mendengarkan.')
            ->assertSee('Kontrol lagu')
            ->assertSee('https://soundcloud.com/leagueoflegends/everything-goes-on-porter-robinson')
            ->assertDontSee('music.youtube.com/watch?v=z5Dd7Lz-YHI');
    }
}
