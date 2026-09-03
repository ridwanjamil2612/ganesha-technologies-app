@extends('layouts.app')
@section('title', 'Portofolio')
@section('meta', 'Rekam jejak Ganesha Flame di sektor kesehatan, pemerintahan, industri, dan peternakan.')

@section('content')
@include('partials.page-hero', [
    'eyebrow' => __('site.porto_page_eyebrow'),
    'heading' => __('site.porto_page_heading'),
    'crumb'   => __('site.nav_portofolio'),
    'lede'    => __('site.porto_page_lede'),
])

{{-- Sektor --}}
<section class="section">
    <div class="wrap">
        <div class="sec-head reveal">
            <p class="eyebrow">{{ __('site.porto_sektor_eyebrow') }}</p>
            <h2 class="title">{{ __('site.porto_sektor_title') }}</h2>
        </div>
        <div class="cards">
            @foreach (config('ganesha.sectors') as $i => $s)
                <div class="card {{ ['c-blue','','c-cyan','c-blue'][$i % 4] }} reveal">
                    <span class="kicker">{{ $s['count'] }} {{ __('site.unit') }}</span>
                    <h3>{{ $s['name'] }}</h3>
                    <p>{{ $s['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Proses --}}
<section class="section section--mist">
    <div class="wrap">
        <div class="sec-head reveal">
            <p class="eyebrow">{{ __('site.porto_pendekatan_eyebrow') }}</p>
            <h2 class="title">{{ __('site.porto_pendekatan_title') }}</h2>
        </div>
        <div class="process">
            @foreach (config('ganesha.process') as $p)
                <div class="ps reveal" style="background:#fff; border-left-color:var(--line)">
                    <b>{{ $p['step'] }}</b><h3>{{ $p['title'] }}</h3><p>{{ $p['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Proyek unggulan --}}
<section class="section section--navy">
    <div class="wrap">
        <div class="sec-head reveal">
            <p class="eyebrow">{{ __('site.porto_proyek_eyebrow') }}</p>
            <h2 class="title">{{ __('site.porto_proyek_title') }}</h2>
            <p class="lede">{{ __('site.porto_proyek_lede') }}</p>
        </div>
        <div class="cards">
            @foreach (collect(config('ganesha.projects'))->take(3) as $pr)
                <div class="card reveal" style="background:#13315a; border-color:#1d4675">
                    <span class="kicker" style="color:#3CC0E4">{{ $pr['sector'] }} · {{ $pr['year'] }}</span>
                    <h3 style="color:#fff">{{ $pr['client'] }}</h3>
                    <p style="color:#AFC4DD">{{ $pr['product'] }} — {{ __('site.kapasitas') }} {{ $pr['capacity'] }}. {{ __('site.lokasi') }}: {{ $pr['location'] }}.</p>
                </div>
            @endforeach
        </div>
        <div class="btn-row"><a class="btn btn--green" href="{{ route('galeri') }}">{{ __('site.buka_galeri') }}</a></div>
    </div>
</section>
@endsection
