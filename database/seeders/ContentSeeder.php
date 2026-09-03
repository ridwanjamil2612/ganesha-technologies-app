<?php

namespace Database\Seeders;

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
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Impor konten awal dari config/ganesha.php ke database.
     * Aman dijalankan berulang (tidak menggandakan data).
     */
    public function run(): void
    {
        $g = config('ganesha');

        // Pengaturan perusahaan (satu baris)
        if (Setting::count() === 0 && !empty($g['company'])) {
            Setting::create($g['company']);
        }

        $this->fill(Stat::class, $g['stats'] ?? []);
        $this->fill(Product::class, $g['products'] ?? []);
        $this->fill(Service::class, $g['services'] ?? []);
        $this->fill(News::class, $g['news'] ?? []);
        $this->fill(Certification::class, $g['certifications'] ?? []);
        $this->fill(Project::class, $g['projects'] ?? []);
        $this->fill(Sector::class, $g['sectors'] ?? []);
        $this->fill(ProcessStep::class, $g['process'] ?? []);
        $this->fill(Faq::class, $g['faq'] ?? []);

        // Standar = daftar string sederhana
        if (Standard::count() === 0) {
            foreach ($g['standards'] ?? [] as $i => $text) {
                Standard::create(['text' => $text, 'sort' => $i]);
            }
        }
    }

    private function fill(string $model, array $rows): void
    {
        if ($model::count() > 0) {
            return; // sudah ada isinya, lewati
        }
        foreach ($rows as $i => $row) {
            $row['sort'] = $i;
            $model::create($row);
        }
    }
}
