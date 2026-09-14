<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{ asset('js/theme.js') }}?v={{ filemtime(public_path('js/theme.js')) }}"></script>
    <meta name="theme-color" content="#fba28c">
    <meta name="description" content="Personal website Kamal Zaky Adinata. Profil mahasiswa Informatika ITS, eksperimen visual, proyek, dan catatan belajar.">
    <title>@yield('title', 'Home') — {{ $profile['short_name'] }}</title>
    <link rel="icon" href="{{ asset('images/favicon.svg') }}" type="image/svg+xml">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/portfolio.css') }}?v={{ filemtime(public_path('css/portfolio.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/motion.css') }}?v={{ filemtime(public_path('css/motion.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/editorial.css') }}?v={{ filemtime(public_path('css/editorial.css')) }}">
    <script src="{{ asset('js/portfolio.js') }}" defer></script>
    <script src="{{ asset('js/motion.js') }}" defer></script>
</head>
<body class="{{ request()->routeIs('home') ? 'is-home' : 'is-inner' }}">
<a class="skip-link" href="#main-content">Lewati ke konten</a>
<div class="reading-progress" aria-hidden="true"></div>
<div class="site-frame">
    <header class="site-header">
        <a class="brand" href="{{ route('home') }}" aria-label="Kamal, beranda"><span class="brand-monogram" aria-hidden="true">{{ $profile['brand'] }}</span></a>
        <span class="header-rule" aria-hidden="true"></span>
        <button class="theme-toggle" type="button" aria-label="Aktifkan mode gelap" aria-pressed="false"><span data-theme-icon aria-hidden="true">◐</span><span data-theme-label>Gelap</span></button>
        <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="main-nav">Menu <span aria-hidden="true">☰</span></button>
        <nav class="main-nav" id="main-nav" aria-label="Navigasi utama">
            @foreach (['home' => 'Home', 'dashboard.index' => 'Academic', 'about' => 'About', 'projects' => 'Projects', 'collection' => 'Collection', 'blog' => 'Blog', 'calculator' => 'Kalkulator'] as $route => $label)
                <a href="{{ route($route) }}" @if(request()->routeIs($route) || ($route === 'dashboard.index' && request()->routeIs('dashboard.*', 'student', 'agent', 'gpa.calculate')) || ($route === 'projects' && request()->routeIs('project')) || ($route === 'blog' && request()->routeIs('article')) || ($route === 'calculator' && request()->routeIs('calculate'))) aria-current="page" @endif>{{ $label }}</a>
            @endforeach
            <a class="contact-link" href="{{ route('contact') }}" @if(request()->routeIs('contact')) aria-current="page" @endif>Contact <span aria-hidden="true">↗</span></a>
        </nav>
    </header>
    <main id="main-content" tabindex="-1">@yield('content')</main>
    <footer class="site-footer">
        <span>© {{ date('Y') }} {{ $profile['name'] }}</span>
        <span class="footer-note">Made with curiosity. <span aria-hidden="true">✳</span></span>
        <a href="{{ route('project') }}">Project idea <span aria-hidden="true">↗</span></a>
    </footer>
</div>
</body>
</html>
