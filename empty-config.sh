#!/usr/bin/env bash
# Kosongkan data contoh di config/ganesha.php (konten via panel admin) - Ganesha.
# Jalankan dari ROOT project (LOKAL):  bash empty-config.sh
set -e
if [ ! -f config/ganesha.php ]; then echo "  ! config/ganesha.php tidak ditemukan (jalankan dari root project)"; exit 1; fi
cp config/ganesha.php config/ganesha.php.bak && echo "  (backup -> config/ganesha.php.bak)"
mkdir -p config
cat > config/ganesha.php <<'CFGEOF__'
<?php

/*
|--------------------------------------------------------------------------
| Data Katalog Ganesha Technologies
|--------------------------------------------------------------------------
| Data konten dikelola melalui panel admin (database). Array di bawah
| sengaja dikosongkan agar situs menampilkan konten asli dari database.
| Data perusahaan (company) dan menu (nav) dipertahankan sebagai dasar;
| detail perusahaan dapat diperbarui melalui menu Pengaturan.
*/

return [

    'company' => [
        'name'      => 'Ganesha Technologies',
        'short'     => 'Ganesha Technologies',
        'tagline'   => '',
        'desc'      => '',
        'email'     => '',
        'phone'     => '',
        'whatsapp'  => '',
        'address'   => '',
        'hours'     => '',
        'founded'   => date('Y'),
    ],

    'stats' => [],

    'products' => [],

    'services' => [],

    'news' => [],

    'certifications' => [],

    'standards' => [],

    'projects' => [],

    'sectors' => [],

    'process' => [],

    'faq' => [],

    'nav' => [
        ['route' => 'produk',       'label' => 'Produk'],
        ['route' => 'portofolio',   'label' => 'Portofolio'],
        ['route' => 'berita',       'label' => 'Berita'],
        ['route' => 'sertifikasi',  'label' => 'Sertifikasi'],
        ['route' => 'galeri',       'label' => 'Galeri'],
        ['route' => 'faq',          'label' => 'FAQ'],
    ],
];
CFGEOF__
echo "  ok: config/ganesha.php dikosongkan (company & nav dipertahankan)"
php artisan optimize:clear 2>/dev/null || true
echo ""
echo "SELESAI. Lalu commit & push:"
echo "  git add . && git commit -m \"Kosongkan data contoh config\" && git push"
