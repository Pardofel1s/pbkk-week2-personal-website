@extends('layouts.app')
@section('title', 'Blog')
@section('content')
<section class="page-content">
    <div class="page-heading"><p class="eyebrow">NOTES ALONG THE WAY / BLOG</p><h1>Thinking out loud.<br><em>One note at a time.</em></h1><p>Catatan implementasi dari perjalanan membangun website ini.</p></div>
    <div class="blog-tools"><div class="filter-bar" data-filter-group="blog" aria-label="Filter artikel">@foreach(['All', 'Laravel', 'Design', 'Learning'] as $category)<button type="button" class="filter-button" data-filter="{{ $category }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}">{{ $category }}</button>@endforeach</div><label class="search-field"><span class="visually-hidden">Cari artikel</span><input type="search" placeholder="Cari catatan…" data-search="blog"><span aria-hidden="true">⌕</span></label></div>
    <p class="result-count" data-count="blog" aria-live="polite">3 catatan</p>
    <div class="blog-list">@foreach($profile['articles'] as $slug => $article)<article class="blog-row" data-filter-item="blog" data-category="{{ $article['category'] }}" data-search-text="{{ $article['title'] }} {{ $article['summary'] }}"><div class="blog-index">0{{ $loop->iteration }}</div><div><div class="article-meta"><span>{{ $article['category'] }}</span><time datetime="{{ $article['date'] }}">05 Sep 2026</time><span>{{ $article['reading_time'] }} baca</span></div><h2><a href="{{ route('article', $slug) }}">{{ $article['title'] }}</a></h2><p>{{ $article['summary'] }}</p></div><a class="round-link" href="{{ route('article', $slug) }}" aria-label="Baca {{ $article['title'] }}">↗</a></article>@endforeach</div>
    <p class="empty-state" data-empty="blog" hidden>Tidak ada catatan yang cocok. Coba kata lain atau pilih All.</p>
</section>
@endsection
