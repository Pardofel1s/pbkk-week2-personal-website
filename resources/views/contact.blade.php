@extends('layouts.app')
@section('title', 'Contact')
@section('content')
<section class="page-content contact-page">
    <div class="page-heading"><p class="eyebrow">A CONVERSATION STARTS HERE / CONTACT</p><h1>Have a thought?<br><em>Say hello.</em></h1><p>Tentang kode, ide, atau kemungkinan berkolaborasi.<br>Aku bisa dihubungi melalui kanal berikut.</p></div>
    <div class="contact-grid">
        <div class="contact-letter"><span class="letter-star" aria-hidden="true">✳</span><p class="eyebrow">TO {{ strtoupper($profile['short_name']) }}</p><h2>Good things start<br>with a <em>hello.</em></h2><a class="pill-button" href="mailto:{{ $profile['email'] }}">Write an email ↗</a><span class="letter-signature">{{ $profile['short_name'] }}.</span></div>
        <div class="contact-details"><a class="contact-row" href="mailto:{{ $profile['email'] }}"><span><small>EMAIL</small><strong>{{ $profile['email'] }}</strong></span><span aria-hidden="true">↗</span></a><a class="contact-row" href="https://wa.me/{{ $profile['whatsapp'] }}" target="_blank" rel="noopener noreferrer"><span><small>WHATSAPP</small><strong>{{ $profile['phone'] }}</strong></span><span aria-hidden="true">↗</span></a>@foreach($profile['socials'] as $label => $url)<a class="contact-row" href="{{ $url }}" target="_blank" rel="noopener noreferrer"><span><small>{{ strtoupper($label) }}</small><strong>{{ $label === 'GitHub' ? 'Pardofel1s' : $profile['name'] }}</strong></span><span aria-hidden="true">↗</span></a>@endforeach<div class="contact-location"><span class="status-dot"></span>{{ $profile['location'] }}</div></div>
    </div>
</section>
@endsection
