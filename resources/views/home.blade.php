@extends('layouts.app')
@section('title', 'Home')
@section('content')
<section class="hero" aria-labelledby="hero-heading">
    <div class="hero-copy">
        <p class="eyebrow"><span class="status-dot"></span> Informatics student · ITS</p>
        <h1 id="hero-heading">HELLO!<br>I’M <em>KAMAL.</em></h1>
        <p class="hero-intro">A curious mind.<br>A little code. A personal point of view.</p>
        <p class="identity">{{ $profile['name'] }} <span>NRP {{ $profile['nrp'] }}</span></p>
        <a class="text-link" href="#playground">Come take a look around <span aria-hidden="true">↘</span></a>
    </div>
    <div class="hero-art">
        <span class="art-caption">01 / A WORK IN CURIOSITY</span>
        <div class="envelope" id="hero-envelope">
            <div class="paper paper-back"><span>KEEP<br>EXPLORING.</span><span class="paper-cross" aria-hidden="true">✳</span></div>
            <div class="paper paper-middle"><span class="paper-word">MAKE<br><em>something.</em></span><span class="paper-small">A SPACE FOR SMALL IDEAS</span></div>
            <div class="paper paper-front"><span class="paper-number">K.</span><span class="paper-small">DESIGN · CODE · REPEAT</span></div>
            <div class="envelope-pocket"><span>A FEW THINGS ABOUT ME</span></div>
            <button class="envelope-toggle" type="button" aria-label="Buka kartu showcase" aria-expanded="false" aria-controls="hero-envelope"><svg viewBox="0 0 32 32" aria-hidden="true"><path d="M10 6 26 16 10 26Z"/></svg></button>
        </div>
        <span class="art-footnote">An idea is a good place to start.</span>
    </div>
    <nav class="hero-rail" aria-label="Bagian halaman Home">
        <span class="rail-line"></span>
        <a href="#playground">My playground <span>01</span></a>
        <a href="#about-me">A little about me <span>02</span></a>
        <a href="#next-chapter">Next chapter <span>03</span></a>
        <span class="rail-line"></span>
    </nav>
    <div class="hero-bottom"><span>BASED IN SURABAYA, ID</span><a href="#playground">SCROLL TO EXPLORE <span aria-hidden="true">↓</span></a></div>
</section>
<section class="content-section" id="playground" aria-labelledby="playground-heading">
    <div class="section-heading"><div><p class="eyebrow">01 / THE PLAYGROUND</p><h2 id="playground-heading">Small things.<br><em>Room to play.</em></h2></div><p>Eksperimen visual dari website ini.<br>Coba sentuh, klik, dan ubah suasananya.</p></div>
    <div class="row g-4 showcase-grid">
        <div class="col-md-4"><article class="showcase-card"><div class="demo-demo demo-stack"><div class="mini-paper mini-one"></div><div class="mini-paper mini-two"></div><div class="mini-paper mini-three">hello.</div><button class="demo-action" type="button" data-stack-toggle aria-pressed="false">Spread the cards <span aria-hidden="true">↗</span></button></div><p class="eyebrow">01 / LAYERS</p><h3>A study in paper.</h3><p>Tumpukan sederhana, sedikit rotasi, dan ruang untuk bergerak.</p></article></div>
        <div class="col-md-4"><article class="showcase-card"><div class="demo-demo demo-glass"><span class="glass-orb"></span><div class="glass-sample">a little<br><em>softer.</em></div><label class="range-label">Blur <input type="range" min="0" max="24" value="12" data-blur aria-label="Atur blur kaca"><output data-blur-value>12 px</output></label></div><p class="eyebrow">02 / TEXTURE</p><h3>Through the glass.</h3><p>Geser intensitas blur dan lihat bagaimana lapisannya berubah.</p></article></div>
        <div class="col-md-4"><article class="showcase-card"><div class="demo-demo demo-aura" data-aura="peach"><span class="aura-title">aura<span>find your mood.</span></span><div class="swatches" aria-label="Pilih suasana warna"><button type="button" data-aura-choice="peach" aria-label="Suasana peach" aria-pressed="true"></button><button type="button" data-aura-choice="sage" aria-label="Suasana sage" aria-pressed="false"></button><button type="button" data-aura-choice="sunset" aria-label="Suasana sunset" aria-pressed="false"></button></div></div><p class="eyebrow">03 / COLOR</p><h3>A change of atmosphere.</h3><p>Tiga komposisi warna, satu kanvas. Pilih suasana yang kamu suka.</p></article></div>
    </div>
</section>
<section class="content-section about-strip" id="about-me"><div><p class="eyebrow">02 / A LITTLE ABOUT ME</p><h2>Learning by making.<br><em>Making it personal.</em></h2></div><div><p>Aku {{ $profile['short_name'] }}, mahasiswa Teknik Informatika ITS. Website ini menjadi tempat untuk menghubungkan yang dipelajari di kelas dengan sesuatu yang bisa dilihat, dicoba, dan dikembangkan.</p><a class="text-link" href="{{ route('about') }}">My academic home <span aria-hidden="true">↗</span></a></div></section>
<section class="content-section chapter-section" id="next-chapter"><p class="eyebrow">03 / THE NEXT CHAPTER</p><h2>What comes <em>next?</em></h2><p>Eksperimen hari ini bisa menjadi ide yang lebih besar besok.</p><a class="pill-button" href="{{ route('project') }}">Explore the project idea <span aria-hidden="true">↗</span></a></section>
@endsection
