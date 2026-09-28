@extends('layouts.app')
@section('title', 'Contact')
@section('content')
<section class="page-content inner-studio correspondence-folio">
    <header class="folio-heading" data-reveal>
        <p class="folio-kicker"><span>05 / CORRESPONDENCE</span><span>{{ $profile['location'] }}</span></p>
        <h1>A good beginning:<br><em>“Hello, Kamal.”</em></h1>
    </header>
    <div class="correspondence-spread">
        <div class="correspondence-note" data-reveal>
            <span class="correspondence-stamp" aria-hidden="true">K<span>SURABAYA<br>INDONESIA</span></span>
            <p class="eyebrow">A NOTE TO {{ strtoupper($profile['short_name']) }}</p>
            <h2>Some things start<br>with a <em>conversation.</em></h2>
            <p>Tentang kode, ide yang belum selesai, atau kemungkinan berkolaborasi. Saya senang mendengar apa yang sedang kamu pikirkan.</p>
            <a class="pill-button" href="mailto:{{ $profile['email'] }}">Write a little hello <span aria-hidden="true">↗</span></a>
            <span class="correspondence-signature">{{ $profile['short_name'] }}.</span>
        </div>
        <div class="correspondence-addresses" data-reveal>
            <p class="eyebrow">FIND ME HERE</p>
            <a class="address-entry" href="mailto:{{ $profile['email'] }}"><span><small>01 / EMAIL</small><strong>{{ $profile['email'] }}</strong></span><span aria-hidden="true">↗</span></a>
            <a class="address-entry" href="https://wa.me/{{ $profile['whatsapp'] }}" target="_blank" rel="noopener noreferrer"><span><small>02 / WHATSAPP</small><strong>{{ $profile['phone'] }}</strong></span><span aria-hidden="true">↗</span></a>
            @foreach($profile['socials'] as $label => $url)
            <a class="address-entry" href="{{ $url }}" target="_blank" rel="noopener noreferrer"><span><small>0{{ $loop->iteration + 2 }} / {{ strtoupper($label) }}</small><strong>{{ $label === 'GitHub' ? 'Pardofel1s' : $profile['name'] }}</strong></span><span aria-hidden="true">↗</span></a>
            @endforeach
            <p class="correspondence-location">Sent from <em>{{ $profile['location'] }}.</em></p>
        </div>
    </div>
</section>
@endsection
