@php
    /** @var string $eyebrow, $heading, $lede, $crumb */
@endphp
<section class="page-hero">
    <img class="deco" src="{{ asset('img/cluster-hero.svg') }}" alt="">
    <div class="wrap">
        <p class="breadcrumb"><a href="{{ route('home') }}">{{ __('site.beranda') }}</a> &nbsp;/&nbsp; {{ $crumb ?? $heading }}</p>
        <p class="eyebrow">{{ $eyebrow ?? '' }}</p>
        <h1 class="display">{{ $heading }}</h1>
        @isset($lede)<p class="lede">{{ $lede }}</p>@endisset
    </div>
</section>
