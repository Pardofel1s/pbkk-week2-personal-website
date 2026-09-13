@extends('layouts.app', ['profile' => config('portfolio')])
@section('title', 'Halaman tidak ditemukan')
@section('content')
<section class="page-content not-found"><p class="eyebrow">404 / A SMALL DETOUR</p><h1>This page took<br><em>another path.</em></h1><p>Halaman atau catatan yang kamu cari belum tersedia.</p><a class="pill-button" href="{{ route('home') }}">Back to Home ↗</a></section>
@endsection
