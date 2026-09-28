@extends('layouts.app')
@section('title', 'Collection')
@section('content')
<section class="page-content inner-studio collection-folio">
    <header class="folio-heading" data-reveal>
        <p class="folio-kicker"><span>03 / A CABINET OF CURIOSITIES</span><span>Collected, with care.</span></p>
        <h1>For the<br><em>curious eye.</em></h1>
        <div class="folio-heading-note"><span class="folio-handmark" aria-hidden="true">↳</span><p>Huruf, warna, dan halaman yang saya simpan.<br>Referensi kecil di balik website ini.</p></div>
    </header>
    <div class="filter-bar folio-filters" data-filter-group="collection" aria-label="Filter koleksi">
        @foreach(['All', 'Design', 'Typography', 'Learning'] as $category)
            <button type="button" class="filter-button" data-filter="{{ $category }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}">{{ $category }}</button>
        @endforeach
        <span class="result-count" data-count="collection" aria-live="polite">{{ count($profile['collection']) }} items</span>
    </div>
    <div class="specimen-shelf">
        @foreach($profile['collection'] as $item)
        <article class="specimen" data-filter-item="collection" data-category="{{ $item['category'] }}" data-reveal>
            <a class="specimen-art specimen-art--{{ $item['visual'] }}" href="{{ $item['url'] ?: route('home').'#playground' }}" @if($item['url']) target="_blank" rel="noopener noreferrer" @endif aria-label="Jelajahi {{ $item['title'] }}">
                <small>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }} / {{ strtoupper($item['category']) }}</small>
                @if($item['visual'] === 'palette')
                    <div class="specimen-swatches" aria-hidden="true"><i></i><i></i><i></i><i></i></div>
                @else
                    <span class="specimen-mark" aria-hidden="true">{{ $item['mark'] }}</span>
                @endif
                <span class="specimen-corner" aria-hidden="true">↗</span>
            </a>
            <div class="specimen-caption"><h2>{{ $item['title'] }}</h2><p>{{ $item['description'] }}</p></div>
        </article>
        @endforeach
    </div>
</section>
@endsection
