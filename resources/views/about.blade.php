@extends('layouts.app')
@section('title', 'About')
@section('content')
<section class="page-content inner-studio about-folio">
    <header class="folio-heading" data-reveal>
        <p class="folio-kicker"><span>01 / THE ACADEMIC HOME</span><span>Surabaya, Indonesia</span></p>
        <h1>Good questions.<br><em>New possibilities.</em></h1>
        <div class="folio-heading-note"><span class="folio-handmark" aria-hidden="true">↳</span><p>Tempat rasa ingin tahu bertemu dasar ilmu.<br>Tempat saya belajar membangun sesuatu yang berarti.</p></div>
    </header>
    <div class="about-spread">
        <div class="campus-print" data-reveal>
            <div class="print-caption"><span>INSTITUT TEKNOLOGI<br>SEPULUH NOPEMBER</span><span>EST. 1960</span></div>
            <span class="campus-type" aria-hidden="true">ITS<span>↗</span></span>
            <div class="campus-lines" aria-hidden="true"><i></i><i></i><i></i><i></i></div>
            <div class="print-foot"><span>INFORMATIKA</span><span>Learning, in progress.</span></div>
        </div>
        <div class="about-copy" data-reveal>
            <p class="eyebrow">DEPARTEMEN TEKNIK INFORMATIKA</p>
            <h2>Belajar memahami.<br><em>Belajar membangun.</em></h2>
            <p>Departemen Teknik Informatika ITS berfokus pada pendidikan, penelitian, dan inovasi di bidang ilmu komputer serta rekayasa perangkat lunak. Lingkungan akademik ini menjadi tempat untuk mempelajari dasar komputasi dan mengembangkan penerapannya.</p>
            <p>Bagi saya, belajar Informatika berarti menghubungkan banyak hal: software, data, jaringan, dan keputusan. Mengambil sebuah masalah, memahaminya, lalu membuat sistem yang bisa dicoba.</p>
            <a class="text-link" href="https://www.its.ac.id/informatika/" target="_blank" rel="noopener noreferrer">Jelajahi Informatika ITS <span aria-hidden="true">↗</span></a>
        </div>
    </div>
    <div class="identity-ledger" data-reveal>
        <p class="ledger-caption">A LITTLE CONTEXT</p>
        <dl>
            <div><dt><span>01</span> Mahasiswa</dt><dd><a href="{{ route('student', ['nrp' => $profile['nrp']]) }}">{{ $profile['name'] }} <span aria-hidden="true">↗</span></a></dd></div>
            <div><dt><span>02</span> NRP</dt><dd class="ledger-number">{{ $profile['nrp'] }}</dd></div>
            <div><dt><span>03</span> Mata kuliah</dt><dd>Pemrograman Berbasis<br>Kerangka Kerja</dd></div>
        </dl>
    </div>
    <a class="folio-next" href="{{ route('student', ['nrp' => $profile['nrp']]) }}" data-reveal><span>THE PERSON BEHIND THE PAGES</span><strong>Kenali <em>Kamal.</em></strong><span class="folio-next-arrow" aria-hidden="true">↗</span></a>
</section>
@endsection
