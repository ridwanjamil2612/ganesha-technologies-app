@extends('layouts.app')
@section('title', 'Produk & Layanan')
@section('meta', 'Katalog lengkap insinerator dua ruang bakar Ganesha Flame beserta spesifikasi teknis dan layanan pendukung.')

@section('content')
@include('partials.page-hero', [
    'eyebrow' => __('site.prod_page_eyebrow'),
    'heading' => __('site.prod_page_heading'),
    'crumb'   => __('site.nav_produk'),
    'lede'    => __('site.prod_page_lede'),
])

<section class="section">
    <div class="wrap">
        <div class="sec-head reveal">
            <p class="eyebrow">{{ __('site.katalog_eyebrow') }}</p>
            <h2 class="title">{{ __('site.katalog_title') }}</h2>
            <p class="lede">{{ __('site.katalog_lede') }}</p>
        </div>

        <div class="cards">
            @foreach (config('ganesha.products') as $p)
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
                        <dl class="spec">
                            @foreach ($p['specs'] as $k => $v)
                                <div><dt>{{ $k }}</dt><b>{{ $v }}</b></div>
                            @endforeach
                        </dl>
                        <div class="btn-row" style="margin-top:auto">
                            <a class="btn btn--ghost" href="{{ route('produk.show', $p['slug'] ?? $p['code']) }}">{{ __('site.lihat_detail') }}</a>
                            <a class="btn btn--wa" href="https://wa.me/{{ config('ganesha.company.whatsapp') }}?text={{ urlencode(__('site.wa_tertarik') . $p['name']) }}" target="_blank" rel="noopener">{{ __('site.tanya_unit') }}</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

@php $brochures = \App\Models\Brochure::whereNotNull('file')->orderBy('sort')->orderBy('id')->get(); @endphp
@if ($brochures->isNotEmpty())
<section class="section">
    <div class="wrap">
        <div class="sec-head reveal">
            <p class="eyebrow">{{ app()->getLocale() === 'en' ? 'Download' : 'Unduh' }}</p>
            <h2 class="title">{{ app()->getLocale() === 'en' ? 'Product Brochures' : 'Brosur Produk' }}</h2>
            <p class="lede">{{ app()->getLocale() === 'en' ? 'Download our product brochures and catalogs in PDF.' : 'Unduh brosur dan katalog produk kami dalam format PDF.' }}</p>
        </div>
        <div class="brochure-grid reveal">
            @foreach ($brochures as $b)
                <a class="brochure-card" href="{{ asset('storage/' . $b->file) }}" target="_blank" rel="noopener" download>
                    <div class="brochure-thumb">
                        @if ($b->thumb)
                            <img src="{{ asset('storage/' . $b->thumb) }}" alt="{{ $b->title }}" loading="lazy">
                        @else
                            <svg viewBox="0 0 24 24" width="44" height="44" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M7 3h7l5 5v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/><path d="M14 3v5h5"/>
                                <text x="12" y="17" font-size="4.5" text-anchor="middle" fill="currentColor" stroke="none" font-family="Arial">PDF</text>
                            </svg>
                        @endif
                    </div>
                    <div class="brochure-info">
                        <span class="brochure-title">{{ $b->title }}</span>
                        <span class="brochure-dl">&#8681; {{ app()->getLocale() === 'en' ? 'Download PDF' : 'Unduh PDF' }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="section section--mist">
    <div class="wrap">
        <div class="sec-head reveal">
            <p class="eyebrow">{{ __('site.layanan_eyebrow') }}</p>
            <h2 class="title">{{ __('site.layanan_title2') }}</h2>
            <p class="lede">{{ __('site.layanan_lede') }}</p>
        </div>
        <div class="cards">
            @foreach (config('ganesha.services') as $i => $s)
                <div class="feature reveal">
                    <div class="ic">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                    <div><h3>{{ $s['title'] }}</h3><p>{{ $s['desc'] }}</p></div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
