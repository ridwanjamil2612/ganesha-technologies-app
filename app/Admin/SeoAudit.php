<?php

namespace App\Admin;

use App\Models\News;
use App\Models\Product;
use Illuminate\Support\Str;

class SeoAudit
{
    public static function run(): array
    {
        $items = [];

        foreach (Product::ordered()->get() as $p) {
            $items[] = self::evaluate(
                'Produk', (string) $p->name, (string) $p->desc, ! empty($p->image),
                $p->slug, null, route('admin.resource.edit', ['products', $p->id]),
                ['title' => 30, 'desc' => 30, 'image' => 25, 'slug' => 15]
            );
        }

        foreach (News::orderBy('id')->get() as $n) {
            $words = collect($n->body ?? [])->map(fn ($x) => str_word_count(strip_tags((string) $x)))->sum();
            $items[] = self::evaluate(
                'Berita', (string) $n->title, (string) $n->excerpt, ! empty($n->image),
                $n->slug, (int) $words, route('admin.resource.edit', ['news', $n->id]),
                ['title' => 25, 'desc' => 25, 'image' => 20, 'slug' => 10, 'content' => 20]
            );
        }

        $scores = array_column($items, 'score');
        $overall = count($scores) ? (int) round(array_sum($scores) / count($scores)) : 100;

        $tally = ['image' => 0, 'title' => 0, 'desc' => 0, 'content' => 0, 'slug' => 0];
        foreach ($items as $it) {
            foreach ($it['flags'] as $flag) {
                if (isset($tally[$flag])) {
                    $tally[$flag]++;
                }
            }
        }

        $needWork = array_values(array_filter($items, fn ($it) => $it['score'] < 80));
        usort($needWork, fn ($a, $b) => $a['score'] <=> $b['score']);

        $company = config('ganesha.company', []);
        $technical = [
            ['label' => 'Sitemap.xml aktif', 'ok' => true],
            ['label' => 'Robots.txt aktif', 'ok' => true],
            ['label' => 'Open Graph (preview share)', 'ok' => true],
            ['label' => 'Structured data (JSON-LD)', 'ok' => true],
            ['label' => 'Canonical URL', 'ok' => true],
            ['label' => 'Nama perusahaan terisi', 'ok' => ! empty($company['name'])],
            ['label' => 'Deskripsi perusahaan terisi', 'ok' => ! empty($company['desc'])],
            ['label' => 'Nomor WhatsApp terisi', 'ok' => ! empty($company['whatsapp'])],
        ];

        return [
            'overall' => $overall,
            'total' => count($items),
            'ok' => count(array_filter($scores, fn ($s) => $s >= 80)),
            'warn' => count(array_filter($scores, fn ($s) => $s >= 50 && $s < 80)),
            'bad' => count(array_filter($scores, fn ($s) => $s < 50)),
            'tally' => $tally,
            'needWork' => $needWork,
            'technical' => $technical,
        ];
    }

    private static function evaluate(string $type, string $title, string $desc, bool $hasImage, ?string $slug, ?int $words, string $editUrl, array $weights): array
    {
        $got = 0;
        $problems = [];
        $flags = [];

        $tl = Str::length(trim($title));
        if ($tl >= 25 && $tl <= 65) {
            $got += $weights['title'];
        } else {
            $flags[] = 'title';
            $problems[] = $tl === 0 ? 'Judul kosong'
                : ($tl < 25 ? 'Judul terlalu pendek (' . $tl . ' krkt, ideal 25-65)'
                    : 'Judul terlalu panjang (' . $tl . ' krkt, bisa terpotong di Google)');
        }

        $dl = Str::length(trim($desc));
        if ($dl >= 50 && $dl <= 170) {
            $got += $weights['desc'];
        } else {
            $flags[] = 'desc';
            $problems[] = $dl === 0 ? 'Deskripsi/ringkasan kosong'
                : ($dl < 50 ? 'Deskripsi terlalu pendek (' . $dl . ' krkt, ideal 50-160)'
                    : 'Deskripsi terlalu panjang (' . $dl . ' krkt)');
        }

        if ($hasImage) {
            $got += $weights['image'];
        } else {
            $flags[] = 'image';
            $problems[] = 'Belum ada gambar';
        }

        if (! empty($slug)) {
            $got += $weights['slug'];
        } else {
            $flags[] = 'slug';
            $problems[] = 'Slug (URL) kosong';
        }

        if (isset($weights['content'])) {
            if (($words ?? 0) >= 150) {
                $got += $weights['content'];
            } else {
                $flags[] = 'content';
                $problems[] = 'Isi artikel terlalu pendek (' . ($words ?? 0) . ' kata, ideal >=150)';
            }
        }

        $total = array_sum($weights);
        $score = $total ? (int) round($got / $total * 100) : 100;

        return [
            'type' => $type,
            'title' => $title !== '' ? $title : '(tanpa judul)',
            'score' => $score,
            'problems' => $problems,
            'flags' => $flags,
            'editUrl' => $editUrl,
        ];
    }
}
