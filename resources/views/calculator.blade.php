@extends('layouts.app')
@section('title', 'Kalkulator')
@section('content')
<section class="page-content inner-studio calculator-folio">
    <header class="folio-heading" data-reveal>
        <p class="folio-kicker"><span>06 / THE EVERYDAY WORKSHEET</span><span>Two numbers. One answer.</span></p>
        <h1>Make it<br><em>add up.</em></h1>
        <div class="folio-heading-note"><span class="folio-handmark" aria-hidden="true">↳</span><p>Sedikit ruang untuk berpikir dengan angka.<br>Tambah, kurang, kali, atau bagi.</p></div>
    </header>
    <div class="worksheet" data-reveal>
        <form class="calculator-form worksheet-input" method="GET" action="{{ route('calculator.submit') }}">
            <div class="worksheet-caption"><p class="eyebrow">01 / YOUR NUMBERS</p><span aria-hidden="true">↘</span></div>
            @if($errors->any())<div class="error-message" role="alert">Lengkapi kedua angka dan pilih operasi yang tersedia.</div>@endif
            <label for="angka1">Angka pertama</label><input class="number-input" type="text" inputmode="decimal" id="angka1" name="angka1" value="{{ old('angka1', $angka1) }}" placeholder="10" maxlength="32" required aria-describedby="number-help">
            <fieldset class="operation-picker">
                <legend>Pilih operasi</legend>
                <div class="operation-options">
                @foreach(['tambah' => ['+', 'Tambah'], 'kurang' => ['−', 'Kurang'], 'kali' => ['×', 'Kali'], 'bagi' => ['÷', 'Bagi']] as $key => [$symbol, $label])
                    <label class="operation-choice">
                        <input type="radio" name="operasi" value="{{ $key }}" @checked(old('operasi', $operasi) === $key) required>
                        <span class="operation-tile"><span class="operation-symbol" aria-hidden="true">{{ $symbol }}</span><span>{{ $label }}</span></span>
                    </label>
                @endforeach
                </div>
            </fieldset>
            <label for="angka2">Angka kedua</label><input class="number-input" type="text" inputmode="decimal" id="angka2" name="angka2" value="{{ old('angka2', $angka2) }}" placeholder="5" maxlength="32" required aria-describedby="number-help">
            <p id="number-help" class="field-help">Angka negatif dan desimal diperbolehkan. Gunakan titik untuk desimal; batas ±1 triliun.</p>
            <div class="form-actions"><button class="pill-button" type="submit">Hitung hasilnya <span aria-hidden="true">↗</span></button><a class="text-link" href="{{ route('calculator') }}">Reset</a></div>
        </form>
        <div class="calculation-output worksheet-output" aria-live="polite">
            <p class="eyebrow">02 / A LITTLE CLARITY</p>
            @if($calculationError)
                <span class="worksheet-symbol" aria-hidden="true">!</span><h2>Let’s try<br><em>that again.</em></h2><p class="error-message" role="alert">{{ $calculationError }}</p>
            @elseif($result !== null)
                <p class="result-expression">{{ $angka1 }} {{ ['tambah'=>'+','kurang'=>'−','kali'=>'×','bagi'=>'÷'][$operasi] }} {{ $angka2 }} =</p><output class="result-number">{{ $result }}</output><p>Hasil dari {{ $angka1 }} {{ $operasi }} {{ $angka2 }} adalah {{ $result }}</p><p class="field-help">Hasil ditampilkan hingga 12 digit signifikan.</p><button class="text-link copy-link" data-copy-url type="button">Salin tautan hasil ↗</button><span class="copy-feedback" role="status"></span>
            @else
                <span class="worksheet-symbol" aria-hidden="true">=</span><h2>A blank space<br><em>for the answer.</em></h2><p>Isi kedua angka, pilih operasinya.<br>Hasilnya akan muncul di sini.</p><a class="text-link" href="{{ route('calculate', ['angka1'=>10, 'angka2'=>5, 'operasi'=>'kali']) }}">Coba 10 × 5 ↗</a>
            @endif
            <div class="worksheet-rules" aria-hidden="true"><i></i><i></i><i></i></div>
        </div>
    </div>
</section>
@endsection
