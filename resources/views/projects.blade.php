@extends('layouts.app')
@section('title', 'Projects')
@section('content')
<section class="page-content inner-studio work-folio">
    <header class="folio-heading" data-reveal>
        <p class="folio-kicker"><span>02 / SELECTED EXPERIMENTS</span><span>{{ str_pad(count($profile['projects']), 2, '0', STR_PAD_LEFT) }} studies & counting</span></p>
        <h1>Less wondering.<br><em>More making.</em></h1>
        <div class="folio-heading-note"><span class="folio-handmark" aria-hidden="true">↳</span><p>Proyek dan eksperimen dari personal website ini.<br>Satu ide kecil, satu percobaan, lalu versi berikutnya.</p></div>
    </header>
    <div class="work-studies">
        @foreach ($profile['projects'] as $item)
        <article class="work-study" data-reveal>
            <a class="study-cover study-cover--{{ $item['visual'] }}" href="{{ route($item['route']) }}{{ $item['anchor'] ?? '' }}" aria-label="Buka {{ $item['subtitle'] }}">
                <div class="study-cover-caption"><span>STUDY / {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><span>{{ $item['subtitle'] }}</span></div>
                @if($item['visual'] === 'portfolio')
                    <div class="study-browser" aria-hidden="true"><div class="study-browser-bar">K. <span>A PERSONAL SPACE</span></div><strong>Hello,<br>I'm <em>Kamal.</em></strong><span class="study-browser-foot">A little curiosity goes a long way. ↗</span></div>
                @elseif($item['visual'] === 'playground')
                    <div class="study-papers" aria-hidden="true"><span>What<br><em>if?</em></span><span>Make<br><em>it.</em></span><span>Try<br><em>again.</em></span></div>
                @else
                    <div class="study-equation" aria-hidden="true"><span>10 <i>×</i> 5</span><strong><i>=</i> 50<span>.</span></strong></div>
                @endif
                <span class="study-cover-open" aria-hidden="true">↗</span>
            </a>
            <div class="study-description">
                <div class="study-index"><span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><span>{{ $item['status'] }}</span></div>
                <p class="eyebrow">{{ $item['subtitle'] }}</p>
                <h2>{{ $item['title'] }}</h2>
                <p>{{ $item['description'] }}</p>
                <ul class="study-materials" aria-label="Teknologi">@foreach($item['stack'] as $tech)<li>{{ $tech }}</li>@endforeach</ul>
                <div class="study-links"><a class="text-link" href="{{ route($item['route']) }}{{ $item['anchor'] ?? '' }}">Explore the study ↗</a><a href="{{ $profile['repository'] }}" target="_blank" rel="noopener noreferrer">Source ↗</a></div>
            </div>
        </article>
        @endforeach
    </div>
    <a class="folio-next" href="{{ route('project') }}" data-reveal><span>NEXT IN THE NOTEBOOK / AGENTIC AI</span><strong>What if it could <em>act?</em></strong><span class="folio-next-arrow" aria-hidden="true">↗</span></a>
</section>
@endsection
