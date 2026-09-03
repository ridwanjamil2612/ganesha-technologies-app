<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Resources;
use App\Admin\SeoAudit;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Product;
use App\Models\Project;
use App\Models\Visit;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Inventaris konten per modul
        $counts = [];
        foreach (Resources::all() as $key => $def) {
            $counts[$key] = ['label' => $def['label'], 'count' => $def['model']::count()];
        }

        // ---- Kunjungan ----
        $visitsToday = Visit::whereDate('created_at', Carbon::today())->count();
        $visits30    = Visit::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $visitsTotal = Visit::count();

        // Seri 14 hari terakhir
        $raw = Visit::where('created_at', '>=', Carbon::now()->subDays(13)->startOfDay())
            ->selectRaw('date(created_at) as d, count(*) as c')
            ->groupBy('d')->pluck('c', 'd');
        $series = [];
        for ($i = 13; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i);
            $series[] = [
                'label' => $day->format('d/m'),
                'count' => (int) ($raw[$day->format('Y-m-d')] ?? 0),
            ];
        }

        // Halaman terpopuler (30 hari)
        $topPages = Visit::where('created_at', '>=', Carbon::now()->subDays(30))
            ->selectRaw('path, count(*) as c')
            ->groupBy('path')->orderByDesc('c')->limit(6)->get();

        // Distribusi
        $bySector = Project::selectRaw('COALESCE(NULLIF(sector, ""), "Lainnya") as k, count(*) as c')
            ->groupBy('k')->orderByDesc('c')->get();
        $bySegment = Product::selectRaw('COALESCE(NULLIF(segment, ""), "Lainnya") as k, count(*) as c')
            ->groupBy('k')->orderByDesc('c')->get();

        // Konten terbaru
        $recentNews = News::orderByDesc('date')->orderByDesc('id')->limit(5)->get();
        $recentProjects = Project::orderByDesc('year')->orderByDesc('id')->limit(5)->get();

        // Kelengkapan gambar
        $completeness = [
            'products' => $this->pct(Product::whereNotNull('image')->where('image', '!=', '')->count(), Product::count()),
            'news'     => $this->pct(News::whereNotNull('image')->where('image', '!=', '')->count(), News::count()),
        ];

        // Ringkasan SEO
        $seo = SeoAudit::run();

        return view('admin.dashboard', compact(
            'counts', 'visitsToday', 'visits30', 'visitsTotal', 'series',
            'topPages', 'bySector', 'bySegment', 'recentNews', 'recentProjects', 'completeness', 'seo'
        ));
    }

    private function pct(int $part, int $total): array
    {
        return ['part' => $part, 'total' => $total, 'pct' => $total ? round($part / $total * 100) : 0];
    }
}
