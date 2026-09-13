<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#fba28c">
    <meta name="description" content="Personal website Kamal Zaky Adinata. Profil mahasiswa Informatika ITS, eksperimen visual, proyek, dan catatan belajar.">
    <title>@yield('title', 'Home') — {{ $profile['short_name'] }}</title>
    <link rel="icon" href="{{ asset('images/favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/portfolio.css') }}">
    <link rel="stylesheet" href="{{ asset('css/motion.css') }}">
    <script src="{{ asset('js/portfolio.js') }}" defer></script>
    <script src="{{ asset('js/motion.js') }}" defer></script>
</head>
<body class="{{ request()->routeIs('home') ? 'is-home' : 'is-inner' }}">
<a class="skip-link" href="#main-content">Lewati ke konten</a>
<div class="reading-progress" aria-hidden="true"></div>
<div class="site-frame">
    <header class="site-header">
        <a class="brand" href="{{ route('home') }}" aria-label="Pardofelis, beranda">{{ $profile['brand'] }}<span class="brand-star" aria-hidden="true">✳</span></a>
        <span class="header-rule" aria-hidden="true"></span>
        <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="main-nav">Menu <span aria-hidden="true">☰</span></button>
        <nav class="main-nav" id="main-nav" aria-label="Navigasi utama">
            @foreach (['home' => 'Home', 'about' => 'About', 'projects' => 'Projects', 'collection' => 'Collection', 'blog' => 'Blog', 'calculator' => 'Kalkulator'] as $route => $label)
                <a href="{{ route($route) }}" @if(request()->routeIs($route) || ($route === 'projects' && request()->routeIs('project')) || ($route === 'blog' && request()->routeIs('article')) || ($route === 'calculator' && request()->routeIs('calculate'))) aria-current="page" @endif>{{ $label }}</a>
            @endforeach
            <a class="contact-link" href="{{ route('contact') }}" @if(request()->routeIs('contact')) aria-current="page" @endif>Contact <span aria-hidden="true">↗</span></a>
        </nav>
    </header>
    <main id="main-content" tabindex="-1">@yield('content')</main>
    <footer class="site-footer">
        <span>© {{ date('Y') }} {{ $profile['name'] }}</span>
        <span class="footer-note">Made with curiosity. <span aria-hidden="true">✳</span></span>
        <button class="motion-toggle" data-motion-toggle type="button" aria-pressed="true" hidden>Animations: on</button>
        <a href="{{ route('project') }}">Project idea <span aria-hidden="true">↗</span></a>
    </footer>
</div>
</body>
</html>
