<?php

namespace Tests\Feature;

use Tests\TestCase;

class PagesTest extends TestCase
{
    public static function routeProvider(): array
    {
        return [
            ['/'],
            ['/produk'],
            ['/portofolio'],
            ['/berita'],
            ['/sertifikasi'],
            ['/galeri'],
            ['/faq'],
        ];
    }

    /**
     * @dataProvider routeProvider
     */
    public function test_halaman_publik_dapat_diakses(string $uri): void
    {
        $this->get($uri)->assertOk();
    }

    public function test_detail_berita_pertama_dapat_diakses(): void
    {
        $slug = config('ganesha.news.0.slug');

        $this->get('/berita/'.$slug)->assertOk();
    }

    public function test_berita_tidak_ditemukan_mengembalikan_404(): void
    {
        $this->get('/berita/slug-tidak-ada')->assertNotFound();
    }
}
