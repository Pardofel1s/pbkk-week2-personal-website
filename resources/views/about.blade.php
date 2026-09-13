@extends('layouts.app')
@section('title', 'About')
@section('content')
<section class="page-content">
    <div class="page-heading"><p class="eyebrow">THE ACADEMIC SIDE / ABOUT</p><h1>A place to learn.<br><em>A world to explore.</em></h1><p>Departemen Teknik Informatika<br>Institut Teknologi Sepuluh Nopember</p></div>
    <div class="row g-5 align-items-center">
        <div class="col-lg-5"><div class="academic-poster"><span class="eyebrow">SURABAYA · INDONESIA</span><span class="academic-monogram">ITS<span>INFORMATIKA</span></span><span class="poster-rule"></span><p>Ideas begin with<br><em>a good question.</em></p></div></div>
        <div class="col-lg-7 prose-block"><p class="eyebrow">MY ACADEMIC HOME</p><h2>Belajar memahami.<br>Belajar membangun.</h2><p>Departemen Teknik Informatika ITS berfokus pada pendidikan, penelitian, dan inovasi di bidang ilmu komputer serta rekayasa perangkat lunak. Lingkungan akademik ini menjadi tempat untuk mempelajari dasar komputasi dan mengembangkan penerapannya.</p><p>Dalam mata kuliah Pemrograman Berbasis Kerangka Kerja (PBKK), website ini menjadi latihan membangun aplikasi Laravel dengan pembagian tanggung jawab antara route, controller, dan view.</p><a class="text-link" href="https://www.its.ac.id/informatika/" target="_blank" rel="noopener noreferrer">Kunjungi situs resmi Informatika ITS <span aria-hidden="true">↗</span></a><dl class="profile-facts"><div><dt>Mahasiswa</dt><dd>{{ $profile['name'] }}</dd></div><div><dt>NRP</dt><dd>{{ $profile['nrp'] }}</dd></div><div><dt>Mata kuliah</dt><dd>Pemrograman Berbasis Kerangka Kerja</dd></div></dl></div>
    </div>
</section>
@endsection
