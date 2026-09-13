@extends('layouts.app')
@section('title', $article['title'])
@section('content')
<article class="article-page"><a class="text-link" href="{{ route('blog') }}">← All notes</a><header><div class="article-meta"><span>{{ $article['category'] }}</span><time datetime="{{ $article['date'] }}">05 Sep 2026</time><span>{{ $article['reading_time'] }} baca</span></div><h1>{{ $article['title'] }}</h1><p class="article-lead">{{ $article['summary'] }}</p><p class="article-byline">Catatan implementasi · {{ $profile['name'] }}</p></header><div class="article-body">@foreach($article['sections'] as $section)<section><h2>{{ $section['heading'] }}</h2><p>{{ $section['text'] }}</p></section>@endforeach</div><footer class="article-footer"><p>Keep learning. Keep making.</p><a class="text-link" href="{{ route('blog') }}">Back to all notes ↗</a></footer></article>
@endsection
