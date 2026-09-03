<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [];

        foreach (['home', 'produk', 'portofolio', 'berita', 'sertifikasi', 'galeri', 'faq'] as $r) {
            $urls[] = ['loc' => route($r), 'priority' => $r === 'home' ? '1.0' : '0.8'];
        }

        foreach (config('ganesha.products', []) as $p) {
            $slug = $p['slug'] ?? Str::slug($p['name'] ?? '');
            if ($slug !== '') {
                $urls[] = ['loc' => route('produk.show', $slug), 'priority' => '0.7'];
            }
        }

        foreach (config('ganesha.news', []) as $n) {
            if (! empty($n['slug'])) {
                $urls[] = [
                    'loc' => route('berita.show', $n['slug']),
                    'lastmod' => $n['date'] ?? null,
                    'priority' => '0.6',
                ];
            }
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $u) {
            $xml .= "  <url>\n    <loc>" . htmlspecialchars($u['loc']) . "</loc>\n";
            if (! empty($u['lastmod'])) {
                $xml .= "    <lastmod>" . htmlspecialchars($u['lastmod']) . "</lastmod>\n";
            }
            $xml .= "    <priority>" . $u['priority'] . "</priority>\n  </url>\n";
        }
        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    public function robots()
    {
        $lines = [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin',
            'Disallow: /admin/',
            '',
            'Sitemap: ' . url('sitemap.xml'),
        ];

        return response(implode("\n", $lines), 200)->header('Content-Type', 'text/plain');
    }
}
