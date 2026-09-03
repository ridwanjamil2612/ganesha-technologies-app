@extends('layouts.app')
@section('title', 'Sertifikasi & Standar')
@section('meta', 'Sertifikasi mesin, standar teknis, dan dokumen compliance Ganesha Flame.')

@section('content')
@include('partials.page-hero', [
    'eyebrow' => __('site.cert_page_eyebrow'),
    'heading' => __('site.cert_page_heading'),
    'crumb'   => __('site.nav_sertifikasi'),
    'lede'    => __('site.cert_page_lede'),
])

{{-- Sertifikat --}}
<section class="section">
    <div class="wrap">
        <div class="sec-head reveal">
            <p class="eyebrow">{{ __('site.cert_sertifikat_eyebrow') }}</p>
            <h2 class="title">{{ __('site.cert_sertifikat_title') }}</h2>
        </div>
        <div class="cards">
            @foreach (config('ganesha.certifications') as $cert)
                <article class="cert reveal">
                    <span class="badge">{{ $cert['code'] }}</span>
                    <h3>{{ $cert['title'] }}</h3>
                    <p>{{ $cert['desc'] }}</p>
                    <span class="status">● {{ $cert['status'] }}</span>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- Standar teknis --}}
<section class="section section--mist">
    <div class="wrap intro-2col">
        <div class="reveal">
            <p class="eyebrow">{{ __('site.cert_standar_eyebrow') }}</p>
            <h2 class="title">{{ __('site.cert_standar_title') }}</h2>
            <p class="lede">{{ __('site.cert_standar_lede') }}</p>
            <div class="btn-row">
                <a class="btn" href="https://wa.me/{{ config('ganesha.company.whatsapp') }}" target="_blank" rel="noopener">{{ __('site.minta_dokumen') }}</a>
            </div>
        </div>
        <ul class="checklist reveal">
            @foreach (config('ganesha.standards') as $st)
                <li>{{ $st }}</li>
            @endforeach
        </ul>
    </div>
</section>
@endsection
