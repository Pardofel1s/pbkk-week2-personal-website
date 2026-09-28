@extends('layouts.app')
@section('title', $title)
@section('content')
<section class="page-content inner-studio academic-folio">
    <header class="folio-heading academic-folio-heading" data-reveal>
        <p class="folio-kicker"><span>KAMAL / ACADEMIC JOURNAL</span><span>Informatika ITS · 2024</span></p>
        @if($showProfile ?? false)
            <h1>Kamal Zaky<br><em>Adinata.</em></h1>
        @else
            <h1>{{ $title }}</h1>
        @endif
        <div class="folio-heading-note"><span class="folio-handmark" aria-hidden="true">↳</span><p>{{ $description }}</p></div>
    </header>

    @if(request()->routeIs('dashboard.index'))
    <nav class="academic-directory" aria-label="Pilih ruang akademis">
        <a href="{{ route('dashboard.student', ['nrp' => $profile['nrp']]) }}" data-reveal><span class="directory-number">01</span><div><p class="eyebrow">THE PERSON</p><h2>Profil & <em>perjalanan.</em></h2><p>Pendidikan, riset, dan hal-hal yang saya bangun.</p></div><span class="directory-arrow" aria-hidden="true">↗</span></a>
        <a href="{{ route('dashboard.agent', ['tema' => 'dast']) }}" data-reveal><span class="directory-number">02</span><div><p class="eyebrow">THE IDEA</p><h2>Systems meet <em>curiosity.</em></h2><p>Eksplorasi Agentic AI untuk memahami konteks dan memilih aksi.</p></div><span class="directory-arrow" aria-hidden="true">↗</span></a>
        <a href="{{ route('dashboard.gpa') }}" data-reveal><span class="directory-number">03</span><div><p class="eyebrow">THE NUMBERS</p><h2>A little <em>reflection.</em></h2><p>Hitung rata-rata IP dan lihat perjalanan akademismu.</p></div><span class="directory-arrow" aria-hidden="true">↗</span></a>
    </nav>
    @elseif($showProfile ?? false)
        <div class="academic-overview" data-reveal>
            <div class="academic-personal-mark" aria-hidden="true"><span>K.</span><small>A STUDENT OF<br>MANY CONNECTIONS.</small></div>
            <div class="academic-record">
                <p class="eyebrow">THE ACADEMIC RECORD</p>
                <dl class="academic-metrics">
                    <x-info-card label="IPK" value="{{ $profile['gpa'] }} / 4.00" tone="peach" />
                    <x-info-card label="SKS ditempuh" value="{{ $profile['credits'] }} SKS" tone="sage" />
                </dl>
                <dl class="academic-identifiers">
                    <div><dt>NRP</dt><dd>{{ $profile['nrp'] }}</dd></div>
                    <div><dt>Email</dt><dd><a href="mailto:{{ $profile['email'] }}">{{ $profile['email'] }} ↗</a></dd></div>
                    <div><dt>Riwayat studi</dt><dd>2024–sekarang · S1 Teknik Informatika ITS</dd></div>
                </dl>
                <p class="record-date">Ringkasan transkrip sementara per {{ $profile['academic_date'] }}.</p>
            </div>
        </div>
        @foreach(['education' => 'Pendidikan', 'experience' => 'Pengalaman & organisasi'] as $key => $heading)
        <section class="journey-section" data-reveal>
            <div class="journey-heading"><span class="eyebrow">0{{ $loop->iteration }} / THE JOURNEY</span><h2>{{ $heading }}</h2></div>
            <div class="journey-timeline">
                @foreach($profile[$key] as $item)
                <article class="journey-entry"><p class="eyebrow">{{ $item['period'] }}</p><h3>{{ $item['title'] }}</h3><p>{{ $item['detail'] }}</p></article>
                @endforeach
            </div>
        </section>
        @endforeach
        <section class="recognition-section" data-reveal>
            <div class="journey-heading"><span class="eyebrow">03 / SMALL MILESTONES</span><h2>Pencapaian<br>& <em>proyek.</em></h2></div>
            <ol class="recognition-list">@foreach($profile['highlights'] as $highlight)<li><span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>{{ $highlight }}</li>@endforeach</ol>
        </section>
        <section class="skills-note" data-reveal><span class="eyebrow">04 / MY TOOLBOX</span><h2>Keterampilan,<br><em>terus bertumbuh.</em></h2><p>{{ $profile['skills'] }}</p></section>
    @elseif($showGpa ?? false)
        <div class="gpa-workspace" data-reveal>
            <div class="gpa-form-note"><p class="eyebrow">A QUICK REFLECTION</p><div class="gpa-formula" aria-hidden="true"><span>IP₁ + IP₂</span><span>2</span></div><p>Dua semester dengan bobot yang sama.<br>Untuk IPK resmi, gunakan bobot SKS.</p></div>
            <form action="{{ route('dashboard.gpa.submit') }}" method="GET" class="gpa-form">
                @foreach(['ipk1' => 'IP semester pertama', 'ipk2' => 'IP semester kedua'] as $field => $label)
                <div><label for="{{ $field }}">{{ $label }}</label><input id="{{ $field }}" name="{{ $field }}" type="number" min="0" max="4" step="0.01" placeholder="0.00" value="{{ old($field, request()->route($field)) }}" required></div>
                @endforeach
                @if($errors->any())<p class="error-message" role="alert">{{ $errors->first() }}</p>@endif
                <button class="pill-button" type="submit">Hitung rata-rata <span aria-hidden="true">↗</span></button>
            </form>
        </div>
    @else
        <div class="concept-folio" data-reveal>
            <div class="concept-print" aria-hidden="true"><small>AN IDEA IN PROGRESS</small><span>Observe.<br><em>Think.</em><br>Act.</span><i>↗</i></div>
            <div class="concept-notes">
                <p class="eyebrow">FROM A QUESTION TO A CONCEPT</p>
                <h2>Memberi ide<br><em>sebuah arah.</em></h2>
                <x-status-banner type="info">Tahap konsep · Belum menjadi sistem yang berjalan.</x-status-banner>
                @if(str_contains($title, 'DAST'))
                    <p>Bagaimana jika pengujian aplikasi dapat menyesuaikan langkahnya dengan respons yang ditemukan?</p>
                    <p>Ide DAST ini mengeksplorasi agen yang memetakan aplikasi, memilih pengujian, dan merangkum temuan beserta saran perbaikan. Pengujian MVP direncanakan pada aplikasi lokal seperti DVWA atau OWASP Juice Shop.</p>
                    <ol class="concept-sequence"><li><span>01</span> Petakan halaman & form</li><li><span>02</span> Uji, amati, lalu evaluasi</li><li><span>03</span> Susun laporan & perbaikan</li></ol>
                @else
                    <p>Ruang untuk mengeksplorasi bagaimana sebuah asisten memahami tujuan, memilih alat yang sesuai, dan menyusun langkah penyelesaian.</p>
                    <ol class="concept-sequence"><li><span>01</span> Pahami permintaan</li><li><span>02</span> Pilih alat & langkah</li><li><span>03</span> Evaluasi hasil</li></ol>
                @endif
            </div>
        </div>
    @endif

    <nav class="academic-crosslinks" aria-label="Navigasi akademis">
        <span class="eyebrow">KEEP EXPLORING</span>
        <a href="{{ route('student', ['nrp' => $profile['nrp']]) }}">Profil ↗</a>
        <a href="{{ route('agent', ['tema' => 'dast']) }}">Ide DAST ↗</a>
        <a href="{{ route('agent') }}">General Assistant ↗</a>
        <a href="{{ route('dashboard.gpa') }}">Kalkulator IPK ↗</a>
        <a href="{{ route('dashboard.index') }}">Dashboard ↗</a>
    </nav>
</section>
@endsection
