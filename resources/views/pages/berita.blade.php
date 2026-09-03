@extends('layouts.app')
@section('title', 'Berita & Artikel')
@section('meta', 'Berita perusahaan, update produk, dan artikel terbaru dari Ganesha Flame.')

@section('content')
@include('partials.page-hero', [
    'eyebrow' => __('site.berita_page_eyebrow'),
    'heading' => __('site.berita_page_heading'),
    'crumb'   => __('site.nav_berita'),
    'lede'    => __('site.berita_page_lede'),
])

<section class="section">
    <div class="wrap">
        <div class="news-list">
            @foreach (config('ganesha.news') as $n)
                <a class="post reveal" href="{{ route('berita.show', $n['slug']) }}">
                    <div class="post-cover">
                        @if (!empty($n['image']))
                            <img src="{{ asset('storage/' . $n['image']) }}" alt="{{ $n['title'] }}"
                                 style="width:100%;height:100%;object-fit:cover">
                        @else
                            @include('partials.cover', ['seed' => $n['slug']])
                        @endif
                    </div>
                    <div class="post-body">
                        <div class="meta">
                            <span class="tag">{{ $n['category'] }}</span>
                            <span>{{ \Carbon\Carbon::parse($n['date'])->translatedFormat('d M Y') }}</span>
                        </div>
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
