@extends('layouts.app')
@section('title', $product['name'])
@section('meta', $product['desc'] ?? config('ganesha.company.desc'))
@section('ogType', 'product')
@section('ogImage', !empty($product['image']) ? asset('storage/'.$product['image']) : asset('img/og-default.png'))
@section('schema')
<script type="application/ld+json">
{!! json_encode(array_filter([
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => $product['name'],
    'sku' => $product['code'] ?? null,
    'category' => $product['segment'] ?? null,
    'description' => $product['desc'] ?? null,
    'image' => !empty($product['image']) ? asset('storage/'.$product['image']) : asset('img/og-default.png'),
    'brand' => ['@type' => 'Brand', 'name' => config('ganesha.company.name')],
]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endsection

@section('content')
<section class="section">
    <div class="wrap">
        <div class="article reveal">
            <p class="breadcrumb" style="color:var(--muted)">
                <a href="{{ route('produk') }}" style="color:var(--blue)">← {{ __('site.kembali_produk') }}</a>
            </p>
            <div class="meta">
                @if (!empty($product['code']))<span class="tag">{{ $product['code'] }}</span>@endif
                @if (!empty($product['segment']))&nbsp; {{ $product['segment'] }}@endif
            </div>
            <h1>{{ $product['name'] }}</h1>

            <div class="article-cover">
                @if (!empty($product['image']))
                    <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}"
                         style="width:100%;height:100%;object-fit:cover">
                @else
                    @include('partials.cover', ['seed' => $product['code'] ?? $product['name'], 'bg' => '#13315a'])
                @endif
            </div>

            @if (!empty($product['capacity']))
                <p><strong>{{ __('site.kapasitas') }}:</strong> {{ $product['capacity'] }}</p>
            @endif

            @if (!empty($product['desc']))
                <p>{{ $product['desc'] }}</p>
            @endif

            @if (!empty($product['specs']))
                <h3>{{ __('site.spesifikasi') }}</h3>
                <dl class="spec">
                    @foreach ($product['specs'] as $k => $v)
                        <div><dt>{{ $k }}</dt><b>{{ $v }}</b></div>
                    @endforeach
                </dl>
            @endif

            <div class="btn-row" style="margin-top:1.8rem">
                <a class="btn btn--wa"
                   href="https://wa.me/{{ config('ganesha.company.whatsapp') }}?text={{ urlencode(__('site.wa_tertarik') . $product['name']) }}"
                   target="_blank" rel="noopener">{{ __('site.tanya_unit') }}</a>
                <a class="btn btn--ghost" href="{{ route('produk') }}">{{ __('site.produk_lainnya') }}</a>
            </div>
        </div>
    </div>
</section>
@endsection
