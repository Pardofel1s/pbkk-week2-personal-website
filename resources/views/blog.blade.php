@extends('layouts.app')
@section('title', 'Blog')
@section('content')
<section class="page-content inner-studio journal-folio">
    <header class="folio-heading" data-reveal>
        <p class="folio-kicker"><span>04 / NOTES FROM THE DESK</span><span>A work in understanding.</span></p>
        <h1>Thinking,<br><em>on paper.</em></h1>
        <div class="folio-heading-note"><span class="folio-handmark" aria-hidden="true">↳</span><p>Hal-hal yang mulai masuk akal setelah dituliskan.<br>Catatan dari perjalanan membangun website ini.</p></div>
    </header>
    <div class="journal-tools">
        <div class="filter-bar folio-filters" data-filter-group="blog" aria-label="Filter artikel">
            @foreach(['All', 'Laravel', 'Design', 'Learning'] as $category)<button type="button" class="filter-button" data-filter="{{ $category }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}">{{ $category }}</button>@endforeach
        </div>
        <label class="search-field"><span class="visually-hidden">Cari artikel</span><input type="search" placeholder="Cari catatan…" data-search="blog"><span aria-hidden="true">⌕</span></label>
    </div>
    <p class="result-count journal-count" data-count="blog" aria-live="polite">{{ count($profile['articles']) }} catatan</p>
    <div class="journal-index">
        @foreach($profile['articles'] as $slug => $article)
        <article class="journal-entry" data-filter-item="blog" data-category="{{ $article['category'] }}" data-search-text="{{ $article['title'] }} {{ $article['summary'] }}" data-reveal>
            <span class="journal-entry-number" aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
            <div class="journal-entry-copy">
                <div class="article-meta"><span>{{ $article['category'] }}</span><time datetime="{{ $article['date'] }}">{{ \Illuminate\Support\Carbon::parse($article['date'])->format('d M Y') }}</time><span>{{ $article['reading_time'] }} baca</span></div>
                <h2><a href="{{ route('article', $slug) }}">{{ $article['title'] }}</a></h2>
                <p>{{ $article['summary'] }}</p>
            </div>
            <a class="journal-open" href="{{ route('article', $slug) }}" aria-label="Baca {{ $article['title'] }}">↗</a>
        </article>
        @endforeach
    </div>
    <p class="empty-state" data-empty="blog" hidden>Tidak ada catatan yang cocok. Coba kata lain atau pilih All.</p>
</section>
@endsection
