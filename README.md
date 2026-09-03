# Ganesha Flame Insinerator — Website Company Profile

Website company profile untuk **Ganesha Flame Insinerator** (produsen mesin insinerator),
dibangun dengan **Laravel 13**. Tampilan dan warna mengikuti elemen visual brand
(biru `#2460A8`, hijau `#90C048`, cyan `#3CC0E4`) dengan motif *cluster* kuarter-lingkaran.

## Halaman

| Route | URL | Isi |
|-------|-----|-----|
| `home` | `/` | Beranda: hero, statistik, ringkasan produk, layanan, sektor, proses, berita |
| `produk` | `/produk` | Katalog produk insinerator lengkap + tabel spesifikasi + layanan |
| `portofolio` | `/portofolio` | Sektor industri, alur kerja proyek, proyek unggulan |
| `berita` | `/berita` | Daftar berita & artikel |
| `berita.show` | `/berita/{slug}` | Detail artikel berita |
| `sertifikasi` | `/sertifikasi` | Sertifikat mesin, standar, dan compliance |
| `galeri` | `/galeri` | Galeri proyek selesai + detail klien (lightbox) |
| `faq` | `/faq` | Pertanyaan yang sering diajukan (accordion) |

## Kebutuhan Sistem

- PHP **8.3+**
- Composer
- (Tidak perlu Node.js / npm — CSS & JS ditulis langsung di `public/`, tanpa build step)
- (Tidak perlu database — semua konten ada di `config/ganesha.php`)

## Cara Menjalankan

```bash
# 1. Install dependency Laravel
composer install

# 2. Siapkan file environment
cp .env.example .env

# 3. Generate application key
php artisan key:generate

# 4. Jalankan server lokal
php artisan serve
```

Buka **http://localhost:8000**.

> Catatan: situs ini tidak memakai database. Driver session & cache sudah diset ke `file`
> di `.env.example`, jadi tidak perlu menjalankan `php artisan migrate`. File
> `database/database.sqlite` kosong disertakan hanya agar koneksi default tidak error.

## Mengubah Konten

Semua teks dan data katalog ada di satu file:

```
config/ganesha.php
```

Di dalamnya Anda bisa menyunting:

- `company` — nama, tagline, deskripsi, email, telepon, **nomor WhatsApp**, alamat
- `stats` — angka statistik di beranda
- `products` — daftar produk insinerator (kode, nama, kapasitas, spesifikasi)
- `services` — layanan
- `news` — artikel berita (judul, slug, tanggal, kategori, isi)
- `certifications` & `standards` — sertifikasi dan standar
- `projects` — proyek untuk halaman galeri & portofolio
- `sectors`, `process`, `faq`, `nav`

> **Penting:** isi `config/ganesha.php` saat ini masih berupa **contoh/placeholder**.
> Ganti dengan data Ganesha Flame yang sebenarnya sebelum dipublikasikan — termasuk
> nomor WhatsApp (`company.whatsapp`, format `62…`), email, alamat, daftar produk,
> sertifikat, dan proyek.

Setelah mengubah `config/`, bersihkan cache config bila perlu:

```bash
php artisan config:clear
```

## Struktur Penting

```
app/Http/Controllers/PageController.php   # Semua aksi halaman
config/ganesha.php                        # SUMBER KONTEN situs
routes/web.php                            # Definisi route
resources/views/
├── layouts/app.blade.php                 # Kerangka HTML (header, footer, font)
├── partials/                             # header, footer, page-hero, cover
└── pages/                                # 1 file Blade per halaman
public/
├── css/style.css                         # Design system lengkap
├── js/main.js                            # Nav mobile, accordion FAQ, lightbox, dll
└── img/                                  # Aset SVG brand (cluster, logo, tile)
```

## Aset Visual

Aset SVG (`public/img/`) dibuat menyesuaikan elemen *cluster* brand:

- `cluster-hero.svg` — grid 6×6 kuarter-lingkaran untuk hero
- `tile-pinwheel.svg`, `tile-hatch.svg` — tile aksen 2×2
- `logo-mark.svg` — logo "flame" dari 3 kelopak brand
- `favicon.svg`

## Kustomisasi Tampilan

Warna, font, radius, dan bayangan diatur lewat CSS variables di bagian `:root`
pada `public/css/style.css`. Ubah di sana untuk menyesuaikan tema secara global.

---

Dibangun dengan Laravel 13 · PHP 8.3+

---

## Panel Admin (Backend)

Situs kini dilengkapi panel admin untuk mengelola seluruh konten (produk, berita,
proyek, sertifikasi, layanan, FAQ, sektor, alur kerja, statistik, standar, dan
data perusahaan) melalui database — **tanpa mengedit `config/ganesha.php` lagi**.

### Cara mengaktifkan

```bash
composer install
cp .env.example .env
php artisan key:generate

# Buat tabel + isi data awal (diimpor dari config/ganesha.php) + akun admin
php artisan migrate --seed

php artisan serve
```

- Situs publik: **http://localhost:8000**
- Login admin: **http://localhost:8000/admin/login**

### Akun admin default

| | |
|---|---|
| Email | `admin@ganeshaflame.co.id` |
| Password | `password` |

> **Wajib:** setelah login pertama, buka menu **Akun** di panel dan ganti email &
> kata sandi tersebut.

### Cara kerja

- `php artisan migrate --seed` menyalin isi `config/ganesha.php` ke database.
- Halaman publik membaca konten dari database secara otomatis (config di-*override*
  saat runtime oleh `AppServiceProvider`). Setiap perubahan di admin langsung tampil.
- Jika database belum dimigrasikan atau masih kosong, situs tetap berjalan memakai
  isi `config/ganesha.php` sebagai cadangan.

### Catatan teknis

- Default memakai database **SQLite** (`database/database.sqlite`) — tidak perlu
  setup server database. Untuk MySQL/PostgreSQL, ubah bagian `DB_*` di `.env`.
- Sesi & cache tetap memakai driver `file`.
- Field khusus di form admin:
  - **Spesifikasi produk**: satu per baris dengan format `Label: Nilai`.
  - **Isi artikel berita**: antar paragraf dipisah satu baris kosong.
  - **Slug berita**: boleh dikosongkan (dibuat otomatis dari judul).
- Struktur: definisi seluruh modul ada di `app/Admin/Resources.php`; CRUD ditangani
  `app/Http/Controllers/Admin/ResourceController.php` dengan view generik di
  `resources/views/admin/`.
