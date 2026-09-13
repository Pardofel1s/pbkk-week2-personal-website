@extends('layouts.app')
@section('title', $title)
@section('content')
<section class="page-content">
    <div class="page-heading"><p class="eyebrow">KAMAL / ACADEMIC JOURNAL</p><h1>{{ $title }}</h1></div>
    <div class="prose-block"><p>{{ $description }}</p>
    @if($showProfile ?? false)
        <dl class="profile-facts">
            <div><dt>NRP</dt><dd>{{ $profile['nrp'] }}</dd></div>
            <div><dt>Email</dt><dd>{{ $profile['email'] }}</dd></div>
            <div><dt>Riwayat studi</dt><dd>2024–sekarang · S1 Teknik Informatika ITS</dd></div>
        </dl>
    @endif
    @if($showGpa ?? false)
        <form action="{{ route('dashboard.gpa.submit') }}" method="GET" class="row g-3 my-4">
            @foreach(['ip1' => 'IP semester pertama', 'ip2' => 'IP semester kedua'] as $field => $label)
            <div class="col-sm-6"><label for="{{ $field }}" class="form-label">{{ $label }}</label><input class="form-control" id="{{ $field }}" name="{{ $field }}" type="number" min="0" max="4" step="0.01" value="{{ old($field) }}" required></div>
            @endforeach
            @if($errors->any())<p role="alert">{{ $errors->first() }}</p>@endif
            <div><button class="btn btn-dark" type="submit">Hitung rata-rata ↗</button></div>
        </form>
    @endif
    <nav class="d-flex flex-wrap gap-4 mt-5" aria-label="Navigasi akademis">
        <a class="text-link" href="{{ route('student', ['nrp' => $profile['nrp']]) }}">Profil ↗</a>
        <a class="text-link" href="{{ route('agent', ['tema' => 'dast']) }}">Ide DAST ↗</a>
        <a class="text-link" href="{{ route('agent') }}">General Assistant ↗</a>
        <a class="text-link" href="{{ route('dashboard.gpa') }}">Kalkulator IPK ↗</a>
        <a class="text-link" href="{{ route('dashboard.index') }}">Dashboard ↗</a>
    </nav></div>
</section>
@endsection
