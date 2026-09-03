<?php

namespace App\Support;

use App\Models\Certification;
use App\Models\Faq;
use App\Models\News;
use App\Models\ProcessStep;
use App\Models\Project;
use App\Models\Product;
use App\Models\Sector;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Standard;
use App\Models\Stat;
use Illuminate\Support\Facades\Schema;

class ContentHydrator
{
    /**
     * Isi ulang config('ganesha.*') untuk konten multi-bahasa,
     * memilih kolom _en saat locale = en (fallback ke ID bila kosong).
     */
    public static function hydrate(string $locale): void
    {
        $pick = fn ($base, $en) => ($locale === 'en' && filled($en)) ? $en : $base;

        try {
            if (! Schema::hasTable('settings')) {
                return;
            }

            // ===== 2a =====
            if ($s = Setting::first()) {
                $company = config('ganesha.company', []);
                $company['tagline'] = $pick($s->tagline, $s->tagline_en) ?? ($company['tagline'] ?? null);
                $company['desc'] = $pick($s->desc, $s->desc_en) ?? ($company['desc'] ?? null);
                config(['ganesha.company' => $company]);
            }

            if (Product::count() > 0) {
                config(['ganesha.products' => Product::ordered()->get()->map(fn ($p) => [
                    'code' => $p->code,
                    'name' => $pick($p->name, $p->name_en),
                    'slug' => $p->slug,
                    'image' => $p->image,
                    'segment' => $pick($p->segment, $p->segment_en),
                    'capacity' => $p->capacity,
                    'desc' => $pick($p->desc, $p->desc_en),
                    'specs' => ($locale === 'en' && filled($p->specs_en)) ? $p->specs_en : ($p->specs ?? []),
                ])->all()]);
            }

            if (News::count() > 0) {
                config(['ganesha.news' => News::ordered()->get()->map(fn ($n) => [
                    'slug' => $n->slug,
                    'title' => $pick($n->title, $n->title_en),
                    'image' => $n->image,
                    'date' => optional($n->date)->format('Y-m-d'),
                    'category' => $n->category,
                    'excerpt' => $pick($n->excerpt, $n->excerpt_en),
                    'body' => ($locale === 'en' && filled($n->body_en)) ? $n->body_en : ($n->body ?? []),
                ])->all()]);
            }

            if (Project::count() > 0) {
                config(['ganesha.projects' => Project::ordered()->get()->map(fn ($p) => [
                    'client' => $p->client,
                    'sector' => $p->sector,
                    'product' => $p->product,
                    'capacity' => $p->capacity,
                    'year' => $p->year,
                    'location' => $p->location,
                    'tile' => $p->tile,
                    'images' => $p->images ?? [],
                ])->all()]);
            }

            // ===== 2b =====
            if (Service::count() > 0) {
                config(['ganesha.services' => Service::ordered()->get()->map(fn ($s) => [
                    'title' => $pick($s->title, $s->title_en),
                    'desc' => $pick($s->desc, $s->desc_en),
                ])->all()]);
            }

            if (Sector::count() > 0) {
                config(['ganesha.sectors' => Sector::ordered()->get()->map(fn ($s) => [
                    'name' => $pick($s->name, $s->name_en),
                    'desc' => $pick($s->desc, $s->desc_en),
                    'count' => $s->count,
                ])->all()]);
            }

            if (ProcessStep::count() > 0) {
                config(['ganesha.process' => ProcessStep::ordered()->get()->map(fn ($p) => [
                    'step' => $p->step,
                    'title' => $pick($p->title, $p->title_en),
                    'desc' => $pick($p->desc, $p->desc_en),
                ])->all()]);
            }

            if (Faq::count() > 0) {
                config(['ganesha.faq' => Faq::ordered()->get()->map(fn ($f) => [
                    'q' => $pick($f->q, $f->q_en),
                    'a' => $pick($f->a, $f->a_en),
                ])->all()]);
            }

            if (Certification::count() > 0) {
                config(['ganesha.certifications' => Certification::ordered()->get()->map(fn ($c) => [
                    'code' => $c->code,
                    'title' => $pick($c->title, $c->title_en),
                    'desc' => $pick($c->desc, $c->desc_en),
                    'status' => $pick($c->status, $c->status_en),
                ])->all()]);
            }

            if (Standard::count() > 0) {
                config(['ganesha.standards' => Standard::ordered()->get()
                    ->map(fn ($st) => $pick($st->text, $st->text_en))->all()]);
            }

            if (Stat::count() > 0) {
                config(['ganesha.stats' => Stat::ordered()->get()->map(fn ($s) => [
                    'value' => $s->value,
                    'label' => $pick($s->label, $s->label_en),
                ])->all()]);
            }
        } catch (\Throwable $e) {
            // diamkan
        }
    }
}
