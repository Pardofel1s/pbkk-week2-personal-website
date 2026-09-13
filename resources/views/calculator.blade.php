@extends('layouts.app')
@section('title', 'Kalkulator')
@section('content')
<section class="page-content calculator-page">
    <div class="page-heading"><p class="eyebrow">A LITTLE EVERYDAY TOOL / KALKULATOR</p><h1>Let’s work<br><em>the numbers.</em></h1><p>Dua angka. Empat operasi. Satu hasil.</p></div>
    <div class="calculator-layout">
        <form class="calculator-form" method="GET" action="{{ route('calculator.submit') }}">
            <p class="eyebrow">YOUR NUMBERS</p>
            @if($errors->any())<div class="error-message" role="alert">Lengkapi kedua angka dan pilih operasi yang tersedia.</div>@endif
            <label for="angka1">Angka pertama</label><input class="number-input" type="text" inputmode="decimal" id="angka1" name="angka1" value="{{ old('angka1', $angka1) }}" placeholder="Contoh: 10" maxlength="32" required aria-describedby="number-help">
            <label for="operasi">Operasi</label><select id="operasi" name="operasi">@foreach(['tambah' => '+  Tambah', 'kurang' => '−  Kurang', 'kali' => '×  Kali', 'bagi' => '÷  Bagi'] as $key => $label)<option value="{{ $key }}" @selected(old('operasi', $operasi) === $key)>{{ $label }}</option>@endforeach</select>
            <label for="angka2">Angka kedua</label><input class="number-input" type="text" inputmode="decimal" id="angka2" name="angka2" value="{{ old('angka2', $angka2) }}" placeholder="Contoh: 5" maxlength="32" required aria-describedby="number-help">
            <p id="number-help" class="field-help">Angka negatif dan desimal diperbolehkan. Gunakan titik untuk desimal; batas ±1 triliun.</p>
            <div class="form-actions"><button class="pill-button" type="submit">Hitung hasilnya <span aria-hidden="true">↗</span></button><a class="text-link" href="{{ route('calculator') }}">Reset</a></div>
        </form>
        <div class="calculation-output" aria-live="polite">
            <p class="eyebrow">THE RESULT</p>
            @if($calculationError)<span class="result-symbol" aria-hidden="true">!</span><h2>Let’s try<br><em>that again.</em></h2><p class="error-message" role="alert">{{ $calculationError }}</p>
            @elseif($result !== null)<p class="result-expression">{{ $angka1 }} {{ ['tambah'=>'+','kurang'=>'−','kali'=>'×','bagi'=>'÷'][$operasi] }} {{ $angka2 }}</p><output class="result-number">{{ $result }}</output><p>Hasil dari {{ $angka1 }} {{ $operasi }} {{ $angka2 }} adalah {{ $result }}</p><p class="field-help">Hasil ditampilkan hingga 12 digit signifikan.</p><button class="text-link copy-link" data-copy-url type="button">Salin tautan hasil ↗</button><span class="copy-feedback" role="status"></span>
            @else<span class="result-symbol" aria-hidden="true">=</span><h2>A little clarity,<br><em>one calculation away.</em></h2><p>Isi angka di samping untuk melihat hasilnya di sini.</p><a class="text-link" href="{{ route('calculate', ['angka1'=>10, 'angka2'=>5, 'operasi'=>'kali']) }}">Coba 10 × 5 ↗</a>@endif
        </div>
    </div>
</section>
@endsection
