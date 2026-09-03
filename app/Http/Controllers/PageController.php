<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Carbon;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function produk()
    {
        return view('pages.produk');
    }

    public function produkShow(string $slug)
    {
        $product = collect(config('ganesha.products', []))->first(function ($p) use ($slug) {
            $s = $p['slug'] ?? \Illuminate\Support\Str::slug($p['name'] ?? '');
            return $s === $slug || ($p['code'] ?? null) === $slug;
        });

        abort_if($product === null, 404);

        return view('pages.produk-detail', ['product' => $product]);
    }

    public function portofolio()
    {
        return view('pages.portofolio');
    }

    public function berita()
    {
        return view('pages.berita');
    }

    public function beritaShow(string $slug)
    {
        $article = collect(config('ganesha.news'))->firstWhere('slug', $slug);

        abort_if($article === null, 404);

        return view('pages.berita-detail', ['article' => $article]);
    }

    public function sertifikasi()
    {
        return view('pages.sertifikasi');
    }

    public function galeri()
    {
        return view('pages.galeri');
    }

    public function faq()
    {
        return view('pages.faq');
    }
}
