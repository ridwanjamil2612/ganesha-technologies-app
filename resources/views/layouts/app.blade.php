<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('ganesha.company.name')) — Ganesha Flame</title>
    <meta name="description" content="@yield('meta', config('ganesha.company.desc'))">

    {{-- SEO --}}
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="robots" content="index, follow">
    <meta property="og:site_name" content="{{ config('ganesha.company.name') }}">
    <meta property="og:locale" content="id_ID">
    <meta property="og:type" content="@yield('ogType', 'website')">
    <meta property="og:title" content="@yield('title', config('ganesha.company.name'))">
    <meta property="og:description" content="@yield('meta', config('ganesha.company.desc'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('ogImage', asset('img/og-default.png'))">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', config('ganesha.company.name'))">
    <meta name="twitter:description" content="@yield('meta', config('ganesha.company.desc'))">
    <meta name="twitter:image" content="@yield('ogImage', asset('img/og-default.png'))">
    <script type="application/ld+json">
    {!! json_encode(array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => config('ganesha.company.name'),
        'url' => url('/'),
        'logo' => asset('img/og-default.png'),
        'description' => config('ganesha.company.desc'),
        'email' => config('ganesha.company.email'),
        'telephone' => config('ganesha.company.phone'),
        'address' => config('ganesha.company.address'),
    ]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
    @yield('schema')

    <link rel="icon" type="image/svg+xml" href="{{ asset('img/Logo2.png') }}">

    {{-- Fonts: Archivo (display) · IBM Plex Sans (body) · IBM Plex Mono (data) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@600;700;800;900&family=IBM+Plex+Mono:wght@500;600&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @include('partials.header')

    <main id="top">
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- Floating WhatsApp --}}
    <a class="wa-float" href="https://wa.me/{{ config('ganesha.company.whatsapp') }}" target="_blank" rel="noopener" aria-label="Chat WhatsApp">
        <svg viewBox="0 0 32 32" fill="#fff"><path d="M16 3C9.4 3 4 8.3 4 14.9c0 2.3.6 4.4 1.8 6.3L4 29l8-2.1c1.8 1 3.9 1.5 6 1.5 6.6 0 12-5.3 12-11.9C30 8.3 24.6 3 16 3zm0 21.7c-1.9 0-3.7-.5-5.3-1.4l-.4-.2-4.7 1.2 1.3-4.6-.3-.5a9.6 9.6 0 0 1-1.5-5.1c0-5.4 4.5-9.8 10-9.8s10 4.4 10 9.8-4.5 9.6-9.9 9.6zm5.5-7.2c-.3-.2-1.8-.9-2-1-.3-.1-.5-.2-.7.2-.2.3-.8 1-1 1.2-.2.2-.4.2-.7.1-1.8-.9-3-1.6-4.2-3.6-.3-.5.3-.5.8-1.6.1-.2 0-.4 0-.6-.1-.2-.7-1.6-.9-2.2-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.2 1.1-1.2 2.8s1.2 3.3 1.4 3.5c.2.2 2.5 3.8 6 5.3 2.2.9 3 1 4.1.8.7-.1 1.8-.7 2-1.4.3-.7.3-1.3.2-1.4-.1-.2-.3-.2-.6-.3z"/></svg>
    </a>

    {{-- Back to top --}}
    <button class="to-top" aria-label="Kembali ke atas">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
    </button>

    {{-- Lightbox container (dipakai halaman Galeri) --}}
    <div class="lightbox" aria-hidden="true">
        <button class="lb-close" aria-label="Tutup">&times;</button>
        <div class="lightbox-card">
            <div class="lb-visual"><img src="" alt="Proyek"></div>
            <div class="lb-body">
                <h3></h3>
                <dl class="proj-info"><div class="lb-meta"></div></dl>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
