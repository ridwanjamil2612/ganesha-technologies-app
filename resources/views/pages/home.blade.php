@extends('layouts.app')
@section('title', 'Insinerator Dua Ruang Bakar')
@section('meta', config('ganesha.company.desc'))

@section('content')
@php
    $c = config('ganesha.company');
    $products = collect(config('ganesha.products'))->take(3);
    $services = collect(config('ganesha.services'))->take(6);
    $sectors = config('ganesha.sectors');
    $process = config('ganesha.process');
    $news = collect(config('ganesha.news'))->take(3);
    $stats = config('ganesha.stats');
@endphp

{{-- HERO --}}
<section class="hero">
    <div class="wrap">
        <div class="hero-grid">
            <div>
                <p class="eyebrow">{{ __('site.hero_eyebrow', ['year' => $c['founded']]) }}</p>
                <h1 class="display">{!! __('site.hero_headline') !!}</h1>
                <p class="lede">{{ $c['tagline'] }}</p>
                <div class="btn-row">
                    <a class="btn" href="{{ route('produk') }}">{{ __('site.lihat_produk') }}</a>
                    <a class="btn btn--ghost" href="{{ route('galeri') }}">{{ __('site.galeri_proyek') }}</a>
                </div>
            </div>
            <div class="hero-art">
                <img src="{{ asset('img/insinerator-hero2.png') }}" alt="Elemen visual Ganesha Flame">
            </div>
        </div>

        <div class="stats">
            @foreach ($stats as $s)
                <div class="stat reveal"><b>{{ $s['value'] }}</b><span>{{ $s['label'] }}</span></div>
            @endforeach
        </div>
    </div>
</section>

{{-- INTRO --}}
@php
    $vu = $c['video_url'] ?? '';
    $ytid = null; $videoFile = null;
    if ($vu && preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|shorts/|live/))([A-Za-z0-9_-]{11})~', $vu, $m)) {
        $ytid = $m[1];
    } elseif ($vu && preg_match('~\.(mp4|webm|ogg|mov)$~i', $vu)) {
        $videoFile = \Illuminate\Support\Str::startsWith($vu, ['http://', 'https://']) ? $vu : asset(ltrim($vu, '/'));
    } elseif (file_exists(public_path('video/profil.mp4'))) {
        $videoFile = asset('video/profil.mp4');
    }
    $hasVideo = $ytid || $videoFile;
@endphp
<section class="section">
    <div class="wrap intro-2col" style="align-items:center">
        <div class="reveal">
            <p class="eyebrow">{{ __('site.tentang_eyebrow') }}</p>
            <h2 class="title">{{ __('site.intro_title') }}</h2>
            <p class="lede" style="margin-top:1.1rem">{{ $c['desc'] }}</p>
        </div>

        @if ($hasVideo)
            <div class="reveal">
                @if ($ytid)
                    <div style="position:relative;aspect-ratio:16/9;border-radius:14px;overflow:hidden;background:#0E2747;box-shadow:0 20px 45px -25px rgba(0,0,0,.45)">
                        <iframe src="https://www.youtube.com/embed/{{ $ytid }}" title="Video profil {{ $c['name'] ?? '' }}"
                            style="position:absolute;inset:0;width:100%;height:100%;border:0" loading="lazy"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                @else
                    <video controls playsinline preload="metadata"
                        style="width:100%;aspect-ratio:16/9;object-fit:contain;display:block;border-radius:14px;background:#0E2747;box-shadow:0 20px 45px -25px rgba(0,0,0,.45)">
                        <source src="{{ $videoFile }}">
                        Browser Anda tidak mendukung pemutaran video.
                    </video>
                @endif
            </div>
        @endif
    </div>
</section>

{{-- PRODUK preview --}}
<section class="section section--mist">
    <div class="wrap">
        <div class="sec-head reveal">
            <p class="eyebrow">{{ __('site.produk_eyebrow') }}</p>
            <h2 class="title">{{ __('site.produk_title') }}</h2>
            <p class="lede">{{ __('site.produk_lede') }}</p>
        </div>
        <div class="cards">
            @foreach ($products as $p)
                <article class="product reveal">
                    <a href="{{ route('produk.show', $p['slug'] ?? $p['code']) }}" class="post-cover" style="display:block">
                        @if (!empty($p['image']))
                            <img src="{{ asset('storage/' . $p['image']) }}" alt="{{ $p['name'] }}">
                        @else
                            @include('partials.cover', ['seed' => $p['code'] ?? $p['name']])
                        @endif
                    </a>
                    <div class="product-top">
                        <span class="product-code">{{ $p['code'] }}</span>
                        <h3><a href="{{ route('produk.show', $p['slug'] ?? $p['code']) }}" style="color:inherit;text-decoration:none">{{ $p['name'] }}</a></h3>
                        <div class="seg">{{ $p['segment'] }}</div>
                        <div class="cap">{{ $p['capacity'] }}</div>
                    </div>
                    <div class="product-body">
                        <p>{{ $p['desc'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="btn-row"><a class="btn" href="{{ route('produk') }}">{{ __('site.semua_produk') }}</a></div>
    </div>
</section>

{{-- LAYANAN --}}
<section class="section">
    <div class="wrap">
        <div class="sec-head reveal">
            <p class="eyebrow">{{ __('site.layanan_eyebrow') }}</p>
            <h2 class="title">{{ __('site.layanan_title') }}</h2>
        </div>
        <div class="cards">
            @foreach ($services as $i => $s)
                <div class="feature reveal">
                    <div class="ic">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                    <div><h3>{{ $s['title'] }}</h3><p>{{ $s['desc'] }}</p></div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- SEKTOR --}}
<section class="section section--navy">
    <div class="wrap">
        <div class="sec-head reveal">
            <p class="eyebrow">{{ __('site.sektor_eyebrow') }}</p>
            <h2 class="title">{{ __('site.sektor_title') }}</h2>
        </div>
        <div class="cards">
            @foreach ($sectors as $s)
                <div class="card c-blue reveal" style="background:#13315a; border-color:#1d4675">
                    <span class="kicker" style="color:#3CC0E4">{{ $s['count'] }} {{ __('site.unit') }}</span>
                    <h3 style="color:#fff">{{ $s['name'] }}</h3>
                    <p style="color:#AFC4DD">{{ $s['desc'] }}</p>
                </div>
            @endforeach
        </div>
        <div class="btn-row"><a class="btn btn--green" href="{{ route('portofolio') }}">{{ __('site.lihat_portofolio') }}</a></div>
    </div>
</section>

{{-- PROSES --}}
<section class="section">
    <div class="wrap">
        <div class="sec-head reveal">
            <p class="eyebrow">{{ __('site.proses_eyebrow') }}</p>
            <h2 class="title">{{ __('site.proses_title') }}</h2>
        </div>
        <div class="process">
            @foreach ($process as $p)
                <div class="ps reveal"><b>{{ $p['step'] }}</b><h3>{{ $p['title'] }}</h3><p>{{ $p['desc'] }}</p></div>
            @endforeach
        </div>
    </div>
</section>

{{-- BERITA --}}
<section class="section section--mist">
    <div class="wrap">
        <div class="sec-head reveal">
            <p class="eyebrow">{{ __('site.berita_eyebrow') }}</p>
            <h2 class="title">{{ __('site.berita_title') }}</h2>
        </div>
        <div class="news-list">
            @foreach ($news as $n)
                <a class="post reveal" href="{{ route('berita.show', $n['slug']) }}">
                    <div class="post-cover">
                        @if (!empty($n['image']))
                            <img src="{{ asset('storage/' . $n['image']) }}" alt="{{ $n['title'] }}">
                        @else
                            @include('partials.cover', ['seed' => $n['slug']])
                        @endif
                    </div>
                    <div class="post-body">
                        <div class="meta"><span class="tag">{{ $n['category'] }}</span>
                            <span>{{ \Carbon\Carbon::parse($n['date'])->translatedFormat('d M Y') }}</span></div>
                        <h3>{{ $n['title'] }}</h3>
                        <p>{{ $n['excerpt'] }}</p>
                        <span class="more">{{ __('site.baca_selengkapnya') }} →</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
