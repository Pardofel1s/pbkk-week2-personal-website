@extends('layouts.app')
@section('title', 'Home')
@section('content')
<div class="studio-home">
    <section class="studio-hero" id="home-top" data-page-section data-section-label="Home" aria-labelledby="hero-heading">
        <div class="hero-copy">
            <p class="eyebrow">A personal field journal · Surabaya, ID</p>
            @if(!empty($visitorName ?? null))
                <x-status-banner type="success">Selamat datang, {{ $visitorName }}.</x-status-banner>
            @endif
            <h1 id="hero-heading"><span>Hello there,</span>I'm <em>Kamal.</em></h1>
            <div class="hero-introduction">
                <span class="margin-number" aria-hidden="true">(01)</span>
                <div>
                    <p>Merangkai software, data, dan keputusan.<br>Selalu ada sesuatu untuk dipelajari.</p>
                    <p class="identity">Informatika ITS · {{ $profile['nrp'] }}</p>
                    <a class="text-link" href="{{ route('projects') }}">Lihat yang sedang kubangun <span aria-hidden="true">↗</span></a>
                </div>
            </div>
        </div>
        <div class="desk-composition">
            <div class="desk-heading"><span>Letters from my desk</span><span>01—03</span></div>
            <div class="letter-desk" id="letter-desk">
                <button class="desk-card desk-card-sage" type="button" data-note="explore" data-note-title="Stay curious." aria-label="Baca kartu Stay curious" aria-haspopup="dialog">
                    <span class="desk-card-index">02 / A WAY OF THINKING</span>
                    <span class="desk-card-title">Stay<br><em>curious.</em></span>
                    <svg class="card-orbit" viewBox="0 0 160 100" fill="none" aria-hidden="true"><ellipse cx="80" cy="50" rx="66" ry="27" transform="rotate(-25 80 50)"/><ellipse cx="80" cy="50" rx="66" ry="27" transform="rotate(25 80 50)"/><circle cx="80" cy="50" r="5"/></svg>
                    <span class="desk-message" hidden>Aku senang mencari tahu bagaimana sesuatu bekerja. Dari backend dan jaringan hingga AI dan optimisasi, bagian paling menariknya adalah menghubungkan ide-ide itu menjadi sistem yang berguna.</span>
                </button>
                <button class="desk-card desk-card-cream" type="button" data-note="love" data-note-title="To Angela, with love." aria-label="Baca surat untuk Angela" aria-haspopup="dialog">
                    <span class="desk-card-index">03 / SOMETHING PERSONAL</span>
                    <span class="desk-card-title">With<br><em>love.</em></span>
                    <span class="desk-card-signature">a letter, just for you</span>
                    <span class="desk-message" hidden>Untuk Angela Vania Sugiyono — terima kasih sudah menjadi rumah paling hangat di setiap langkahku. Kamu membuat hari-hari sederhana terasa istimewa. Dengan sayang, Kamal.</span>
                </button>
                <button class="desk-card desk-card-coral" type="button" data-note="hello" data-note-title="Nice to meet you." aria-label="Baca kartu perkenalan Kamal" aria-haspopup="dialog">
                    <span class="desk-card-index">01 / A SMALL INTRODUCTION</span>
                    <span class="desk-card-title">Kamal,<br><em>in a nutshell.</em></span>
                    <span class="desk-card-signature">student, maker, curious human.</span>
                    <span class="desk-message" hidden>Selamat datang di ruang kecilku. Aku Kamal Zaky Adinata, mahasiswa Teknik Informatika ITS angkatan 2024. Aku menikmati proses mengubah masalah nyata menjadi sistem yang bisa dipahami, diuji, dan dikembangkan bersama.</span>
                </button>
                <div class="desk-pocket" aria-hidden="true"><span>PERSONAL CORRESPONDENCE</span><span class="pocket-mark">K.</span><span>SURABAYA ↗ ANYWHERE</span></div>
                <button class="desk-toggle" type="button" aria-controls="letter-desk" aria-expanded="false"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m9 5 10 7-10 7Z"/></svg><span data-desk-label>Press play</span></button>
            </div>
            <p class="desk-caption" aria-live="polite" data-desk-hint>Tiga kartu, sedikit cerita. Buka amplopnya.</p>
            <noscript><p>{{ $profile['bio'] }}</p></noscript>
        </div>
    </section>
    <section class="studio-section" id="playground" data-page-section data-section-label="Workbench" aria-labelledby="playground-heading">
        <div class="studio-section-heading" data-reveal>
            <p class="eyebrow">01 / On the workbench</p>
            <h2 id="playground-heading">Serious curiosity.<br><em>A little play.</em></h2>
            <p>Sebar kartu, atur kejernihan kaca,<br>atau pilih suasana warnanya.</p>
        </div>
        <div class="workbench">
            <article class="workbench-study study-paper" data-reveal>
                <div class="study-meta"><span>Study Nº 01</span><span>Paper & movement</span></div>
                <div class="demo-demo demo-stack"><div class="mini-paper mini-one"><span>one.</span></div><div class="mini-paper mini-two"><span>two.</span></div><div class="mini-paper mini-three">hello.<span>small beginnings</span></div><button class="demo-action" type="button" data-stack-toggle aria-pressed="false"><span data-stack-label>Spread the cards</span><span aria-hidden="true">↗</span></button></div>
                <div class="study-caption"><h3>A study in paper.</h3><p>Ruang kecil untuk ide yang belum selesai.</p></div>
            </article>
            <article class="workbench-study study-glass" data-reveal>
                <div class="study-meta"><span>Study Nº 02</span><span>A different perspective</span></div>
                <div class="demo-demo demo-glass" data-blur-demo style="--glass-blur: 12px; --slider-progress: 50%">
                    <div class="glass-stage" aria-hidden="true">
                        <span class="glass-orb"></span><span class="glass-lines"></span>
                        <div class="glass-sample"><span>a little</span><em>softer.</em><small>GLASS STUDY / 02</small></div>
                        <span class="glass-coordinate">FIG. 02 — LIGHT THROUGH TEXTURE</span>
                    </div>
                    <div class="glass-control">
                        <div class="glass-control-heading"><span>Atur kejernihan</span><output data-blur-value aria-live="polite">12 px</output></div>
                        <div class="glass-range-wrap">
                            <span aria-hidden="true">Clear</span>
                            <input type="range" min="0" max="24" step="1" value="12" data-blur aria-label="Atur blur kaca" aria-valuetext="12 piksel">
                            <span aria-hidden="true">Dream</span>
                        </div>
                        <div class="glass-presets" role="group" aria-label="Preset kejernihan kaca">
                            <button type="button" data-blur-preset="0" aria-pressed="false">Clear <span>0</span></button>
                            <button type="button" data-blur-preset="12" aria-pressed="true">Soft <span>12</span></button>
                            <button type="button" data-blur-preset="24" aria-pressed="false">Dream <span>24</span></button>
                        </div>
                    </div>
                </div>
                <div class="study-caption"><h3>Look a little closer.</h3><p>Geser kontrol atau pilih preset untuk mengubah blur.</p></div>
            </article>
            <article class="workbench-study study-color" data-reveal>
                <div class="study-meta"><span>Study Nº 03</span><span>Color & feeling</span></div>
                <div class="demo-demo demo-aura" data-aura="blossom"><span class="aura-title">aura<span data-aura-copy aria-live="polite">Coral · peach · sage</span></span><div class="swatches" role="group" aria-label="Pilih harmoni warna"><button type="button" data-aura-choice="blossom" data-aura-copy="Coral · peach · sage" aria-label="Coral, peach, dan sage" aria-pressed="true"></button><button type="button" data-aura-choice="garden" data-aura-copy="Garden · sage · cream · peach" aria-label="Sage, cream, dan peach" aria-pressed="false"></button><button type="button" data-aura-choice="afterglow" data-aura-copy="Afterglow · deep coral · peach" aria-label="Deep coral dan peach" aria-pressed="false"></button></div></div>
                <div class="study-caption"><h3>A change of atmosphere.</h3><p>Tiga warna, tiga suasana.</p></div>
            </article>
        </div>
    </section>
    <section class="studio-section person-section" id="about-me" data-page-section data-section-label="About me" aria-labelledby="person-heading">
        <div data-reveal><p class="eyebrow">02 / The person behind the pixels</p><h2 id="person-heading">A mind for systems.<br><em>A heart for making.</em></h2><a class="text-link" href="{{ route('student', ['nrp' => $profile['nrp']]) }}">Profil & pengalaman <span aria-hidden="true">↗</span></a></div>
        <div class="person-copy" data-reveal><p>{{ $profile['bio'] }}</p><dl class="person-ledger"><div><dt>Currently studying</dt><dd>Informatika, ITS <span>Angkatan 2024</span></dd></div><div><dt>The academic part</dt><dd>{{ $profile['gpa'] }} <small>/ 4.00 IPK</small><span>{{ $profile['credits'] }} SKS · {{ $profile['academic_date'] }}</span></dd></div><div><dt>What connects it all</dt><dd>Software · AI · Decision science</dd></div></dl></div>
    </section>
    <section class="studio-section next-section" id="next-chapter" data-page-section data-section-label="Next" aria-labelledby="next-heading" data-reveal>
        <p class="eyebrow">03 / A page still being written</p>
        <a class="next-link" href="{{ route('project') }}"><h2 id="next-heading">What comes<br><em>next?</em></h2><span class="next-arrow" aria-hidden="true">↗</span><span class="next-link-caption">Explore the project idea <span aria-hidden="true">↗</span></span></a>
        <p>Eksperimen hari ini. Kemungkinan baru besok.</p>
    </section>
</div>
<dialog class="note-reader" aria-labelledby="reader-title">
    <div class="reader-stage">
        <button class="reader-close" type="button" aria-label="Tutup kartu">Close <span aria-hidden="true">×</span></button>
        <button class="reader-peek peek-before" type="button" data-note-step="-1"><span>Previous letter</span><strong data-peek-title></strong><span aria-hidden="true">↖</span></button>
        <article class="reader-paper" data-reader-paper>
            <p class="reader-index" data-reader-index></p>
            <h2 id="reader-title"></h2>
            <p class="reader-message" data-reader-message></p>
            <span class="reader-signature">Kamal.</span>
        </article>
        <button class="reader-peek peek-after" type="button" data-note-step="1"><span>Next letter</span><strong data-peek-title></strong><span aria-hidden="true">↘</span></button>
        <div class="reader-pagination"><span data-reader-count aria-live="polite"></span><span>← → untuk berganti · Esc untuk kembali</span></div>
    </div>
</dialog>
@endsection
