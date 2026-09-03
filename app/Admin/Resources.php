<?php

namespace App\Admin;

use App\Models\Certification;
use App\Models\Faq;
use App\Models\News;
use App\Models\ProcessStep;
use App\Models\Product;
use App\Models\Project;
use App\Models\Sector;
use App\Models\Service;
use App\Models\Standard;
use App\Models\Stat;

class Resources
{
    public static function all(): array
    {
        return [
            'products' => [
                'label' => 'Produk', 'singular' => 'Produk', 'model' => Product::class,
                'index' => ['code' => 'Kode', 'name' => 'Nama', 'segment' => 'Segmen', 'capacity' => 'Kapasitas'],
                'seo' => ['title' => 'name', 'desc' => 'desc', 'slug' => 'slug', 'content' => null, 'image' => 'image'],
                'fields' => [
                    ['name' => 'code', 'label' => 'Kode', 'type' => 'text', 'rules' => 'nullable|string|max:50'],
                    ['name' => 'name', 'label' => 'Nama produk', 'type' => 'text', 'rules' => 'required|string|max:150'],
                    ['name' => 'name_en', 'label' => 'Name (English)', 'type' => 'text', 'rules' => 'nullable|string|max:150'],
                    ['name' => 'slug', 'label' => 'Slug (URL)', 'type' => 'text', 'rules' => 'nullable|string|max:150',
                     'hint' => 'Kosongkan untuk dibuat otomatis dari nama.'],
                    ['name' => 'image', 'label' => 'Gambar produk', 'type' => 'image', 'rules' => 'nullable|image|max:3072',
                     'hint' => 'JPG/PNG/WebP, maks 3 MB. Kosongkan untuk mempertahankan gambar lama.'],
                    ['name' => 'segment', 'label' => 'Segmen', 'type' => 'text', 'rules' => 'nullable|string|max:150'],
                    ['name' => 'segment_en', 'label' => 'Segment (English)', 'type' => 'text', 'rules' => 'nullable|string|max:150'],
                    ['name' => 'capacity', 'label' => 'Kapasitas', 'type' => 'text', 'rules' => 'nullable|string|max:100'],
                    ['name' => 'desc', 'label' => 'Deskripsi', 'type' => 'textarea', 'rules' => 'nullable|string'],
                    ['name' => 'desc_en', 'label' => 'Description (English)', 'type' => 'textarea', 'rules' => 'nullable|string'],
                    ['name' => 'specs', 'label' => 'Spesifikasi', 'type' => 'kvlines', 'rules' => 'nullable|string',
                     'hint' => 'Satu per baris, format "Label: Nilai". Contoh: Kapasitas: 100 kg/jam'],
                    ['name' => 'specs_en', 'label' => 'Specifications (English)', 'type' => 'kvlines', 'rules' => 'nullable|string',
                     'hint' => 'One per line, "Label: Value". Example: Capacity: 100 kg/hour'],
                ],
            ],
            'news' => [
                'label' => 'Berita', 'singular' => 'Berita', 'model' => News::class,
                'index' => ['title' => 'Judul', 'category' => 'Kategori', 'date' => 'Tanggal'],
                'seo' => ['title' => 'title', 'desc' => 'excerpt', 'slug' => 'slug', 'content' => 'body', 'image' => 'image'],
                'fields' => [
                    ['name' => 'title', 'label' => 'Judul', 'type' => 'text', 'rules' => 'required|string|max:200'],
                    ['name' => 'title_en', 'label' => 'Title (English)', 'type' => 'text', 'rules' => 'nullable|string|max:200'],
                    ['name' => 'image', 'label' => 'Gambar sampul', 'type' => 'image', 'rules' => 'nullable|image|max:3072',
                     'hint' => 'JPG/PNG/WebP, maks 3 MB. Kosongkan untuk mempertahankan gambar lama.'],
                    ['name' => 'slug', 'label' => 'Slug (URL)', 'type' => 'text', 'rules' => 'nullable|string|max:200',
                     'hint' => 'Kosongkan untuk dibuat otomatis dari judul.'],
                    ['name' => 'date', 'label' => 'Tanggal', 'type' => 'date', 'rules' => 'nullable|date'],
                    ['name' => 'category', 'label' => 'Kategori', 'type' => 'text', 'rules' => 'nullable|string|max:50'],
                    ['name' => 'excerpt', 'label' => 'Ringkasan', 'type' => 'textarea', 'rules' => 'nullable|string'],
                    ['name' => 'excerpt_en', 'label' => 'Excerpt (English)', 'type' => 'textarea', 'rules' => 'nullable|string'],
                    ['name' => 'body', 'label' => 'Isi artikel', 'type' => 'paragraphs', 'rules' => 'nullable|string',
                     'hint' => 'Pisahkan antar paragraf dengan satu baris kosong.'],
                    ['name' => 'body_en', 'label' => 'Body (English)', 'type' => 'paragraphs', 'rules' => 'nullable|string',
                     'hint' => 'Pisahkan antar paragraf dengan satu baris kosong.'],
                ],
            ],
            'projects' => [
                'label' => 'Proyek / Galeri', 'singular' => 'Proyek', 'model' => Project::class,
                'index' => ['client' => 'Klien', 'sector' => 'Sektor', 'product' => 'Produk', 'year' => 'Tahun'],
                'fields' => [
                    ['name' => 'client', 'label' => 'Klien', 'type' => 'text', 'rules' => 'required|string|max:150'],
                    ['name' => 'sector', 'label' => 'Sektor', 'type' => 'text', 'rules' => 'nullable|string|max:100'],
                    ['name' => 'product', 'label' => 'Produk terpasang', 'type' => 'text', 'rules' => 'nullable|string|max:150'],
                    ['name' => 'capacity', 'label' => 'Kapasitas', 'type' => 'text', 'rules' => 'nullable|string|max:100'],
                    ['name' => 'year', 'label' => 'Tahun', 'type' => 'number', 'rules' => 'nullable|integer|min:1990|max:2100'],
                    ['name' => 'location', 'label' => 'Lokasi', 'type' => 'text', 'rules' => 'nullable|string|max:150'],
                    ['name' => 'tile', 'label' => 'Motif kartu', 'type' => 'select', 'rules' => 'required|in:pinwheel,hatch',
                     'options' => ['pinwheel' => 'Pinwheel', 'hatch' => 'Hatch']],
                    ['name' => 'images', 'label' => 'Galeri gambar (bisa pilih banyak)', 'type' => 'images', 'rules' => 'nullable',
                     'hint' => 'Pilih beberapa gambar sekaligus. JPG/PNG/WebP, maks 3 MB per gambar. Gambar lama bisa dicentang untuk dihapus.'],
                ],
            ],
            'services' => [
                'label' => 'Layanan', 'singular' => 'Layanan', 'model' => Service::class,
                'index' => ['title' => 'Judul', 'desc' => 'Deskripsi'],
                'fields' => [
                    ['name' => 'title', 'label' => 'Judul', 'type' => 'text', 'rules' => 'required|string|max:150'],
                    ['name' => 'title_en', 'label' => 'Title (English)', 'type' => 'text', 'rules' => 'nullable|string|max:150'],
                    ['name' => 'desc', 'label' => 'Deskripsi', 'type' => 'textarea', 'rules' => 'nullable|string'],
                    ['name' => 'desc_en', 'label' => 'Description (English)', 'type' => 'textarea', 'rules' => 'nullable|string'],
                ],
            ],
            'certifications' => [
                'label' => 'Sertifikasi', 'singular' => 'Sertifikat', 'model' => Certification::class,
                'index' => ['code' => 'Kode', 'title' => 'Judul', 'status' => 'Status'],
                'fields' => [
                    ['name' => 'code', 'label' => 'Kode', 'type' => 'text', 'rules' => 'nullable|string|max:80'],
                    ['name' => 'title', 'label' => 'Judul', 'type' => 'text', 'rules' => 'required|string|max:150'],
                    ['name' => 'title_en', 'label' => 'Title (English)', 'type' => 'text', 'rules' => 'nullable|string|max:150'],
                    ['name' => 'desc', 'label' => 'Deskripsi', 'type' => 'textarea', 'rules' => 'nullable|string'],
                    ['name' => 'desc_en', 'label' => 'Description (English)', 'type' => 'textarea', 'rules' => 'nullable|string'],
                    ['name' => 'status', 'label' => 'Status', 'type' => 'text', 'rules' => 'nullable|string|max:80'],
                    ['name' => 'status_en', 'label' => 'Status (English)', 'type' => 'text', 'rules' => 'nullable|string|max:80'],
                ],
            ],
            'standards' => [
                'label' => 'Standar', 'singular' => 'Standar', 'model' => Standard::class,
                'index' => ['text' => 'Poin standar'],
                'fields' => [
                    ['name' => 'text', 'label' => 'Poin standar', 'type' => 'textarea', 'rules' => 'required|string'],
                    ['name' => 'text_en', 'label' => 'Standard point (English)', 'type' => 'textarea', 'rules' => 'nullable|string'],
                ],
            ],
            'sectors' => [
                'label' => 'Sektor', 'singular' => 'Sektor', 'model' => Sector::class,
                'index' => ['name' => 'Nama', 'count' => 'Jumlah', 'desc' => 'Deskripsi'],
                'fields' => [
                    ['name' => 'name', 'label' => 'Nama sektor', 'type' => 'text', 'rules' => 'required|string|max:100'],
                    ['name' => 'name_en', 'label' => 'Name (English)', 'type' => 'text', 'rules' => 'nullable|string|max:100'],
                    ['name' => 'count', 'label' => 'Jumlah (mis. 60+)', 'type' => 'text', 'rules' => 'nullable|string|max:30'],
                    ['name' => 'desc', 'label' => 'Deskripsi', 'type' => 'textarea', 'rules' => 'nullable|string'],
                    ['name' => 'desc_en', 'label' => 'Description (English)', 'type' => 'textarea', 'rules' => 'nullable|string'],
                ],
            ],
            'process' => [
                'label' => 'Alur Kerja', 'singular' => 'Langkah', 'model' => ProcessStep::class,
                'index' => ['step' => 'No.', 'title' => 'Judul', 'desc' => 'Deskripsi'],
                'fields' => [
                    ['name' => 'step', 'label' => 'Nomor (mis. 01)', 'type' => 'text', 'rules' => 'nullable|string|max:10'],
                    ['name' => 'title', 'label' => 'Judul langkah', 'type' => 'text', 'rules' => 'required|string|max:100'],
                    ['name' => 'title_en', 'label' => 'Title (English)', 'type' => 'text', 'rules' => 'nullable|string|max:100'],
                    ['name' => 'desc', 'label' => 'Deskripsi', 'type' => 'textarea', 'rules' => 'nullable|string'],
                    ['name' => 'desc_en', 'label' => 'Description (English)', 'type' => 'textarea', 'rules' => 'nullable|string'],
                ],
            ],
            'faqs' => [
                'label' => 'FAQ', 'singular' => 'FAQ', 'model' => Faq::class,
                'index' => ['q' => 'Pertanyaan'],
                'fields' => [
                    ['name' => 'q', 'label' => 'Pertanyaan', 'type' => 'text', 'rules' => 'required|string|max:255'],
                    ['name' => 'q_en', 'label' => 'Question (English)', 'type' => 'text', 'rules' => 'nullable|string|max:255'],
                    ['name' => 'a', 'label' => 'Jawaban', 'type' => 'textarea', 'rules' => 'nullable|string'],
                    ['name' => 'a_en', 'label' => 'Answer (English)', 'type' => 'textarea', 'rules' => 'nullable|string'],
                ],
            ],
            'stats' => [
                'label' => 'Statistik', 'singular' => 'Statistik', 'model' => Stat::class,
                'index' => ['value' => 'Angka', 'label' => 'Keterangan'],
                'fields' => [
                    ['name' => 'value', 'label' => 'Angka (mis. 120+)', 'type' => 'text', 'rules' => 'required|string|max:40'],
                    ['name' => 'label', 'label' => 'Keterangan', 'type' => 'text', 'rules' => 'required|string|max:150'],
                    ['name' => 'label_en', 'label' => 'Label (English)', 'type' => 'text', 'rules' => 'nullable|string|max:150'],
                ],
            ],
        ];
    }

    public static function find(string $key): ?array
    {
        $all = self::all();
        if (! isset($all[$key])) {
            return null;
        }
        return $all[$key] + ['key' => $key];
    }
}
