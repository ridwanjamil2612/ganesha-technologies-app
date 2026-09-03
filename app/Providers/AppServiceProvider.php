<?php

namespace App\Providers;

use App\Models\Certification;
use App\Models\Faq;
use App\Models\News;
use App\Models\ProcessStep;
use App\Models\Product;
use App\Models\Project;
use App\Models\Sector;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Standard;
use App\Models\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (str_starts_with((string) env('APP_URL'), 'https')) {
            URL::forceScheme('https');
        }

        Carbon::setLocale('id');
        setlocale(LC_TIME, 'id_ID.UTF-8', 'id_ID', 'id');

        $this->hydrateContentFromDatabase();
    }

    private function hydrateContentFromDatabase(): void
    {
        try {
            if (! Schema::hasTable('settings')) {
                return;
            }

            if ($setting = Setting::first()) {
                config(['ganesha.company' => array_merge(
                    config('ganesha.company', []),
                    array_filter($setting->only([
                        'name', 'short', 'tagline', 'desc', 'email',
                        'phone', 'whatsapp', 'address', 'hours', 'founded', 'video_url',
                    ]), fn ($v) => $v !== null)
                )]);
            }

            $this->set('stats', Stat::class, fn ($s) => [
                'value' => $s->value, 'label' => $s->label,
            ]);

            $this->set('products', Product::class, fn ($p) => [
                'code' => $p->code, 'name' => $p->name, 'slug' => $p->slug, 'image' => $p->image,
                'segment' => $p->segment, 'capacity' => $p->capacity, 'desc' => $p->desc,
                'specs' => $p->specs ?? [],
            ]);

            $this->set('services', Service::class, fn ($s) => [
                'title' => $s->title, 'desc' => $s->desc,
            ]);

            $this->set('news', News::class, fn ($n) => [
                'slug' => $n->slug, 'title' => $n->title, 'image' => $n->image,
                'date' => optional($n->date)->format('Y-m-d'),
                'category' => $n->category, 'excerpt' => $n->excerpt,
                'body' => $n->body ?? [],
            ]);

            $this->set('certifications', Certification::class, fn ($c) => [
                'code' => $c->code, 'title' => $c->title,
                'desc' => $c->desc, 'status' => $c->status,
            ]);

            $this->set('projects', Project::class, fn ($p) => [
                'client' => $p->client, 'sector' => $p->sector, 'product' => $p->product,
                'capacity' => $p->capacity, 'year' => $p->year,
                'location' => $p->location, 'tile' => $p->tile,
            ]);

            $this->set('sectors', Sector::class, fn ($s) => [
                'name' => $s->name, 'desc' => $s->desc, 'count' => $s->count,
            ]);

            $this->set('process', ProcessStep::class, fn ($p) => [
                'step' => $p->step, 'title' => $p->title, 'desc' => $p->desc,
            ]);

            $this->set('faq', Faq::class, fn ($f) => [
                'q' => $f->q, 'a' => $f->a,
            ]);

            if (Standard::count() > 0) {
                config(['ganesha.standards' => Standard::ordered()->pluck('text')->all()]);
            }
        } catch (\Throwable $e) {
            //
        }
    }

    private function set(string $key, string $model, callable $map): void
    {
        if ($model::count() > 0) {
            config(["ganesha.$key" => $model::ordered()->get()->map($map)->all()]);
        }
    }
}
