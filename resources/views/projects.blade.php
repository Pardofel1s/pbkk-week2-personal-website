@extends('layouts.app')
@section('title', 'Projects')
@section('content')
<section class="page-content">
    <div class="page-heading"><p class="eyebrow">A FEW THINGS I’M BUILDING / PROJECTS</p><h1>Ideas, made<br><em>a little more real.</em></h1><p>Proyek dan eksperimen dari personal website ini.<br>Satu tempat untuk mencoba, belajar, dan mengembangkan.</p></div>
    <div class="project-grid">
    @foreach ($profile['projects'] as $item)
        <article class="project-card">
            <a class="project-preview preview-{{ $item['visual'] === 'calculator' ? 'numbers' : $item['visual'] }}" href="{{ route($item['route']) }}{{ $item['anchor'] ?? '' }}" aria-label="Buka {{ $item['subtitle'] }}">
                @if($item['visual'] === 'portfolio')<div class="preview-window"><span>PARDOFELIS <i>HOME · PROJECTS</i></span><strong>HELLO!<br>I’M <em>KAMAL.</em></strong><div class="preview-stack"></div></div>
                @elseif($item['visual'] === 'playground')<div class="preview-shape shape-one"></div><div class="preview-shape shape-two"></div><span class="preview-type">play.</span>
                @else<div class="preview-calculator"><span>10 × 5</span><strong>50</strong><div>+ &nbsp; − &nbsp; × &nbsp; ÷</div></div>@endif
                <span class="preview-arrow" aria-hidden="true">↗</span>
            </a>
            <div class="project-meta"><p class="eyebrow">{{ $item['subtitle'] }}</p><span class="status-badge">{{ $item['status'] }}</span></div>
            <h2>{{ $item['title'] }}</h2><p>{{ $item['description'] }}</p>
            <div class="tags">@foreach($item['stack'] as $tech)<span>{{ $tech }}</span>@endforeach</div>
            <div class="card-links"><a href="{{ route($item['route']) }}{{ $item['anchor'] ?? '' }}">Open project ↗</a><a href="{{ $profile['repository'] }}" target="_blank" rel="noopener noreferrer">Source code ↗</a></div>
        </article>
    @endforeach
    </div>
    <aside class="idea-banner"><div><p class="eyebrow">ON THE HORIZON</p><h2>What if an assistant could <em>act?</em></h2><p>Eksplorasi awal ide platform Agentic AI untuk proyek akhir PBKK.</p></div><a class="pill-button" href="{{ route('project') }}">Read the concept ↗</a></aside>
</section>
@endsection
