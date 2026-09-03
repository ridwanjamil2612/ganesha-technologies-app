@extends('layouts.app')
@section('title', $article['title'])
@section('meta', $article['excerpt'])
@section('ogType', 'article')
@section('ogImage', !empty($article['image']) ? asset('storage/'.$article['image']) : asset('img/og-default.png'))
@section('schema')
<script type="application/ld+json">
{!! json_encode(array_filter([
    '@context' => 'https://schema.org',
    '@type' => 'NewsArticle',
    'headline' => $article['title'],
    'datePublished' => !empty($article['date']) ? \Illuminate\Support\Carbon::parse($article['date'])->toIso8601String() : null,
    'articleSection' => $article['category'] ?? null,
    'description' => $article['excerpt'] ?? null,
    'image' => !empty($article['image']) ? asset('storage/'.$article['image']) : asset('img/og-default.png'),
    'author' => ['@type' => 'Organization', 'name' => config('ganesha.company.name')],
    'publisher' => ['@type' => 'Organization', 'name' => config('ganesha.company.name'), 'logo' => ['@type' => 'ImageObject', 'url' => asset('img/og-default.png')]],
]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endsection

@section('content')
<section class="section">
    <div class="wrap">
        <div class="article reveal">
            <p class="breadcrumb" style="color:var(--muted)">
                <a href="{{ route('berita') }}" style="color:var(--blue)">← {{ __('site.kembali_berita') }}</a>
            </p>
            <div class="meta">
                <span class="tag">{{ $article['category'] }}</span>
                &nbsp; {{ \Carbon\Carbon::parse($article['date'])->translatedFormat('d F Y') }}
            </div>
            <h1>{{ $article['title'] }}</h1>
            <div class="article-cover">
                @if (!empty($article['image']))
                    <img src="{{ asset('storage/' . $article['image']) }}" alt="{{ $article['title'] }}"
                         style="width:100%;height:100%;object-fit:cover">
                @else
                    @include('partials.cover', ['seed' => $article['slug'], 'bg' => '#13315a'])
                @endif
            </div>

            @foreach ($article['body'] as $para)
                <p>{{ $para }}</p>
            @endforeach

            @php
                $shareUrl = rawurlencode(url()->current());
                $shareText = rawurlencode($article['title']);
            @endphp
            <div class="share">
                <span class="share-label">{{ __('site.bagikan') }}</span>
                <div class="share-btns">
                    <a class="share-btn wa" href="https://wa.me/?text={{ $shareText }}%20{{ $shareUrl }}" target="_blank" rel="noopener" aria-label="WhatsApp">
                        <svg viewBox="0 0 24 24"><path d="M17.5 14.4c-.3-.1-1.7-.8-2-.9-.3-.1-.5-.1-.7.2-.2.3-.7.9-.9 1.1-.2.2-.3.2-.6.1-1.6-.8-2.7-1.4-3.7-3.2-.3-.5.3-.5.8-1.5.1-.2 0-.4 0-.5 0-.1-.7-1.6-.9-2.2-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.4s1.1 2.8 1.2 3c.1.2 2.1 3.3 5.2 4.6.7.3 1.3.5 1.7.6.7.2 1.4.2 1.9.1.6-.1 1.7-.7 2-1.4.2-.7.2-1.2.2-1.4-.1-.1-.3-.2-.6-.3zM12 2a10 10 0 0 0-8.6 15l-1.3 4.7 4.8-1.3A10 10 0 1 0 12 2zm0 18.3c-1.5 0-3-.4-4.3-1.2l-.3-.2-2.9.8.8-2.8-.2-.3A8.3 8.3 0 1 1 12 20.3z"/></svg>
                    </a>
                    <a class="share-btn fb" href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener" aria-label="Facebook">
                        <svg viewBox="0 0 24 24"><path d="M22 12a10 10 0 1 0-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7A10 10 0 0 0 22 12z"/></svg>
                    </a>
                    <a class="share-btn x" href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareText }}" target="_blank" rel="noopener" aria-label="X">
                        <svg viewBox="0 0 24 24"><path d="M18.9 2H22l-7 8 8.2 12h-6.4l-5-7.3L6.1 22H3l7.5-8.6L2.6 2H9l4.5 6.6L18.9 2zm-1.1 18h1.7L7.3 3.8H5.5L17.8 20z"/></svg>
                    </a>
                    <a class="share-btn tg" href="https://t.me/share/url?url={{ $shareUrl }}&text={{ $shareText }}" target="_blank" rel="noopener" aria-label="Telegram">
                        <svg viewBox="0 0 24 24"><path d="M22 3.5 2.5 11c-1 .4-1 1.5 0 1.8l4.9 1.5 1.9 5.8c.3.9 1 1 1.6.5l2.7-2.2 4.7 3.5c.6.4 1.4.1 1.6-.6L23 4.6c.3-1-.3-1.5-1-1.1zM8.9 13.7l9-5.5c.3-.2.6.2.4.4l-7.3 6.7c-.3.3-.5.6-.5 1l-.2 1.9-1.4-4.5z"/></svg>
                    </a>
                    <button class="share-btn copy" type="button" data-url="{{ url()->current() }}" aria-label="Copy link">
                        <svg viewBox="0 0 24 24"><path d="M10.6 13.4a1 1 0 0 0 1.4 0l3-3a3 3 0 0 0-4.2-4.2l-1.2 1.2a1 1 0 0 0 1.4 1.4l1.2-1.2a1 1 0 0 1 1.4 1.4l-3 3a1 1 0 0 0 0 1.4zM13.4 10.6a1 1 0 0 0-1.4 0l-3 3a3 3 0 0 0 4.2 4.2l1.2-1.2a1 1 0 0 0-1.4-1.4l-1.2 1.2a1 1 0 0 1-1.4-1.4l3-3a1 1 0 0 0 0-1.4z"/></svg>
                    </button>
                    <button class="share-btn native" type="button" data-url="{{ url()->current() }}" data-title="{{ $article['title'] }}" aria-label="Share" hidden>
                        <svg viewBox="0 0 24 24"><path d="M18 8a3 3 0 1 0-2.8-4H15a3 3 0 0 0 .1 1.9L8.9 9.4a3 3 0 1 0 0 5.2l6.2 3.5a3 3 0 1 0 .9-1.7L9.9 13a3 3 0 0 0 0-2l6.1-3.5A3 3 0 0 0 18 8z"/></svg>
                    </button>
                    <span class="share-copied" hidden>{{ __('site.tautan_disalin') }} ✓</span>
                </div>
            </div>

            <div class="btn-row">
                <a class="btn btn--wa" href="https://wa.me/{{ config('ganesha.company.whatsapp') }}" target="_blank" rel="noopener">{{ __('site.hubungi_kami') }}</a>
                <a class="btn btn--ghost" href="{{ route('berita') }}">{{ __('site.berita_lainnya') }}</a>
            </div>
        </div>
    </div>
</section>

<script>
(function () {
    var nb = document.querySelector('.share-btn.native');
    if (nb && navigator.share) {
        nb.hidden = false;
        nb.addEventListener('click', function () {
            navigator.share({ title: nb.dataset.title, url: nb.dataset.url }).catch(function () {});
        });
    }
    var cb = document.querySelector('.share-btn.copy');
    var msg = document.querySelector('.share-copied');
    if (cb) {
        cb.addEventListener('click', function () {
            var url = cb.dataset.url;
            var done = function () {
                if (msg) { msg.hidden = false; setTimeout(function () { msg.hidden = true; }, 1800); }
            };
            if (navigator.clipboard) {
                navigator.clipboard.writeText(url).then(done).catch(function () { window.prompt('Link:', url); });
            } else {
                window.prompt('Link:', url);
            }
        });
    }
})();
</script>
@endsection
