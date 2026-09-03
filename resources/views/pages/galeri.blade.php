@extends('layouts.app')
@section('title', 'Galeri Proyek')
@section('meta', 'Galeri proyek insinerator yang telah diselesaikan Ganesha Flame beserta detail klien.')

@section('content')
@include('partials.page-hero', [
    'eyebrow' => __('site.gal_page_eyebrow'),
    'heading' => __('site.gal_page_heading'),
    'crumb'   => __('site.nav_galeri'),
    'lede'    => __('site.gal_page_lede'),
])

<section class="section">
    <div class="wrap">
        <div class="gallery">
            @foreach (config('ganesha.projects') as $pr)
                @php
                    $imgs = $pr['images'] ?? [];
                    $imgUrls = array_map(fn ($i) => asset('storage/' . $i), $imgs);
                    $meta = "<div><dt>" . __('site.produk_label') . "</dt><dd>{$pr['product']}</dd></div>"
                          . "<div><dt>" . __('site.kapasitas') . "</dt><dd>{$pr['capacity']}</dd></div>"
                          . "<div><dt>" . __('site.sektor_label') . "</dt><dd>{$pr['sector']}</dd></div>"
                          . "<div><dt>" . __('site.lokasi') . "</dt><dd>{$pr['location']}</dd></div>"
                          . "<div><dt>" . __('site.tahun') . "</dt><dd>{$pr['year']}</dd></div>";
                @endphp
                <article class="proj reveal"
                         data-client="{{ $pr['client'] }}"
                         data-img="{{ !empty($imgUrls) ? $imgUrls[0] : asset('img/tile-' . $pr['tile'] . '.svg') }}"
                         data-images='@json($imgUrls)'
                         data-meta="{{ $meta }}"
                         tabindex="0" role="button" aria-label="{{ __('site.lihat_detail') }} {{ $pr['client'] }}">
                    <div class="proj-visual">
                        @if (!empty($imgs))
                            <img src="{{ $imgUrls[0] }}" alt="{{ $pr['client'] }}" style="width:100%;height:100%;object-fit:cover">
                            @if (count($imgs) > 1)
                                <span class="proj-count">{{ count($imgs) }} foto</span>
                            @endif
                        @else
                            @include('partials.cover', ['seed' => $pr['client']])
                        @endif
                        <span class="sector">{{ $pr['sector'] }}</span>
                    </div>
                    <div class="proj-info">
                        <h3>{{ $pr['client'] }}</h3>
                        <dl>
                            <dt>{{ __('site.unit_label') }}</dt><dd>{{ $pr['product'] }}</dd>
                            <dt>{{ __('site.kapasitas') }}</dt><dd>{{ $pr['capacity'] }}</dd>
                            <dt>{{ __('site.tahun') }}</dt><dd>{{ $pr['year'] }}</dd>
                        </dl>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
