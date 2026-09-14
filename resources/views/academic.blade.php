@extends('layouts.app')
@section('title', $title)
@section('content')
<section class="page-content academic-page">
    <div class="page-heading"><p class="eyebrow">KAMAL / ACADEMIC JOURNAL</p><h1>{{ $title }}</h1></div>
    <div class="academic-intro"><p>{{ $description }}</p></div>
    @if(request()->routeIs('dashboard.index'))
    <div class="academic-cards">
        <a href="{{ route('dashboard.student', ['nrp' => $profile['nrp']]) }}"><span class="eyebrow">01 / THE PERSON</span><h2>Profil &<br><em>perjalanan.</em></h2><p>Pendidikan, riset, dan hal-hal yang saya bangun.</p><span>Kenali Kamal ↗</span></a>
        <a href="{{ route('dashboard.agent', ['tema' => 'dast']) }}"><span class="eyebrow">02 / THE IDEA</span><h2>Curiosity meets<br><em>security.</em></h2><p>Rancangan Agentic AI untuk pengujian keamanan web.</p><span>Jelajahi DAST ↗</span></a>
        <a href="{{ route('dashboard.gpa') }}"><span class="eyebrow">03 / THE NUMBERS</span><h2>A little<br><em>reflection.</em></h2><p>Hitung rata-rata IP dan lihat perjalanan akademismu.</p><span>Buka kalkulator IPK ↗</span></a>
    </div>
    @endif
    <div class="prose-block">
    @if($showProfile ?? false)
        <dl class="profile-facts">
            <div><dt>IPK</dt><dd>{{ $profile['gpa'] }} / 4.00</dd></div>
            <div><dt>SKS ditempuh</dt><dd>{{ $profile['credits'] }} SKS</dd></div>
            <div><dt>NRP</dt><dd>{{ $profile['nrp'] }}</dd></div>
            <div><dt>Email</dt><dd>{{ $profile['email'] }}</dd></div>
            <div><dt>Riwayat studi</dt><dd>2024–sekarang · S1 Teknik Informatika ITS</dd></div>
        </dl>
        <p class="small">Ringkasan transkrip sementara per {{ $profile['academic_date'] }}.</p>
        @foreach(['education' => 'Pendidikan', 'experience' => 'Pengalaman & organisasi'] as $key => $heading)
        <h2 class="mt-5">{{ $heading }}</h2>
        @foreach($profile[$key] as $item)
        <article class="my-4 timeline-entry"><p class="eyebrow">{{ $item['period'] }}</p><h3>{{ $item['title'] }}</h3><p>{{ $item['detail'] }}</p></article>
        @endforeach
        @endforeach
        <h2 class="mt-5">Pencapaian & proyek</h2>
        <ul>@foreach($profile['highlights'] as $highlight)<li>{{ $highlight }}</li>@endforeach</ul>
        <h2 class="mt-5">Keterampilan</h2><p>{{ $profile['skills'] }}</p>
    @endif
    @if($showGpa ?? false)
        <form action="{{ route('dashboard.gpa.submit') }}" method="GET" class="row g-3 my-4">
            @foreach(['ipk1' => 'IP semester pertama', 'ipk2' => 'IP semester kedua'] as $field => $label)
            <div class="col-sm-6"><label for="{{ $field }}" class="form-label">{{ $label }}</label><input class="form-control" id="{{ $field }}" name="{{ $field }}" type="number" min="0" max="4" step="0.01" value="{{ old($field, request()->route($field)) }}" required></div>
            @endforeach
            @if($errors->any())<p role="alert">{{ $errors->first() }}</p>@endif
            <div><button class="pill-button" type="submit">Hitung rata-rata ↗</button></div>
        </form>
    @endif
    <nav class="academic-nav" aria-label="Navigasi akademis">
        <a class="text-link" href="{{ route('student', ['nrp' => $profile['nrp']]) }}">Profil ↗</a>
        <a class="text-link" href="{{ route('agent', ['tema' => 'dast']) }}">Ide DAST ↗</a>
        <a class="text-link" href="{{ route('agent') }}">General Assistant ↗</a>
        <a class="text-link" href="{{ route('dashboard.gpa') }}">Kalkulator IPK ↗</a>
        <a class="text-link" href="{{ route('dashboard.index') }}">Dashboard ↗</a>
    </nav></div>
</section>
@endsection
