@extends('layouts.app')
@section('title', 'Collection')
@section('content')
<section class="page-content">
    <div class="page-heading"><p class="eyebrow">THINGS WORTH KEEPING / COLLECTION</p><h1>A shelf of<br><em>little discoveries.</em></h1><p>Referensi visual dan sumber belajar di balik website ini.<br>Ruang untuk terus menambah hal yang menarik.</p></div>
    <div class="filter-bar" data-filter-group="collection" aria-label="Filter koleksi">@foreach(['All', 'Design', 'Typography', 'Learning'] as $category)<button type="button" class="filter-button" data-filter="{{ $category }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}">{{ $category }}</button>@endforeach<span class="result-count" data-count="collection" aria-live="polite">6 items</span></div>
    <div class="collection-grid">
        @foreach($profile['collection'] as $item)
        <article class="collection-card" data-filter-item="collection" data-category="{{ $item['category'] }}">
            <div class="collection-visual visual-{{ $item['visual'] }}" aria-hidden="true"><span>{{ $item['mark'] }}</span>@if($item['visual'] === 'palette')<i></i><i></i><i></i><i></i>@endif</div>
            <p class="eyebrow">{{ $item['category'] }}</p><h2>{{ $item['title'] }}</h2><p>{{ $item['description'] }}</p>
            @if($item['url'])<a class="text-link" href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer">Explore reference ↗</a>@else<a class="text-link" href="{{ route('home') }}#playground">Try the study ↗</a>@endif
        </article>
        @endforeach
    </div>
</section>
@endsection
