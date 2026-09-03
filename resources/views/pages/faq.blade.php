@extends('layouts.app')
@section('title', 'FAQ')
@section('meta', 'Pertanyaan yang sering diajukan seputar insinerator Ganesha Flame.')

@section('content')
@include('partials.page-hero', [
    'eyebrow' => __('site.faq_page_eyebrow'),
    'heading' => __('site.faq_page_heading'),
    'crumb'   => __('site.nav_faq'),
    'lede'    => __('site.faq_page_lede'),
])

<section class="section">
    <div class="wrap">
        <div class="faq">
            @foreach (config('ganesha.faq') as $i => $item)
                <div class="qa reveal {{ $i === 0 ? 'open' : '' }}">
                    <button class="qa-q" aria-expanded="{{ $i === 0 ? 'true' : 'false' }}">
                        {{ $item['q'] }}
                        <span class="ico" aria-hidden="true"></span>
                    </button>
                    <div class="qa-a"><p>{{ $item['a'] }}</p></div>
                </div>
            @endforeach
        </div>

        <div class="sec-head reveal" style="text-align:center; margin:clamp(2.5rem,5vw,3.5rem) auto 0; max-width:46ch">
            <h2 class="title" style="font-size:clamp(1.4rem,3vw,2rem)">{{ __('site.faq_cta_title') }}</h2>
            <p class="lede" style="margin-inline:auto">{{ __('site.faq_cta_lede') }}</p>
            <div class="btn-row" style="justify-content:center">
                <a class="btn btn--wa" href="https://wa.me/{{ config('ganesha.company.whatsapp') }}" target="_blank" rel="noopener">{{ __('site.tanya_wa') }}</a>
            </div>
        </div>
    </div>
</section>
@endsection
