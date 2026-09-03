@extends('admin.layout')
@section('title', 'Panduan')

@section('content')
<style>
    html { scroll-behavior: smooth; }
    .guide { --g:#4C7A1F; --g2:#3CC0E4; max-width:1050px; }
    .guide-hero{background:linear-gradient(135deg,#4C7A1F,#3CC0E4);color:#fff;border-radius:16px;padding:1.8rem 2rem;margin-bottom:1.6rem;box-shadow:0 18px 40px -24px rgba(76,122,31,.6)}
    .guide-hero h1{margin:0 0 .35rem;color:#fff;font-size:1.7rem}
    .guide-hero p{margin:0;opacity:.94;max-width:64ch;line-height:1.55}
    .guide-hero .guide-meta{margin-top:.9rem;display:flex;gap:.5rem;flex-wrap:wrap}
    .guide-hero .guide-meta span{background:rgba(255,255,255,.18);padding:.28rem .7rem;border-radius:20px;font-size:.78rem;font-weight:600}
    .guide-layout{display:grid;grid-template-columns:230px 1fr;gap:2rem;align-items:start}
    .guide-toc{position:sticky;top:1rem;align-self:start;background:#fff;border:1px solid var(--line);border-radius:12px;padding:.8rem}
    .guide-toc p{margin:.1rem .5rem .5rem;font-size:.72rem;font-weight:800;letter-spacing:.06em;text-transform:uppercase;color:var(--muted)}
    .guide-toc a{display:block;padding:.42rem .7rem;border-radius:8px;color:var(--ink);text-decoration:none;font-size:.9rem;border-left:2px solid transparent}
    .guide-toc a:hover{background:#f2f7ec;border-left-color:var(--g)}
    .guide-content{min-width:0}
    .guide-sec{background:#fff;border:1px solid var(--line);border-radius:14px;padding:1.5rem 1.7rem;margin-bottom:1.2rem;scroll-margin-top:1rem}
    .guide-sec-head{display:flex;align-items:center;gap:.7rem;margin:0 0 1rem;padding-bottom:.8rem;border-bottom:1px solid var(--line)}
    .guide-ico{width:40px;height:40px;flex:none;border-radius:10px;background:#eef6e3;display:grid;place-items:center;font-size:1.25rem}
    .guide-sec-head h2{margin:0;font-size:1.22rem}
    .guide-content h3{font-size:1rem;margin:1.2rem 0 .45rem}
    .guide-content p{line-height:1.66;margin:.5rem 0}
    .guide-content code{background:#eef3e6;padding:.13rem .42rem;border-radius:5px;font-size:.86em;color:#33520f}
    .guide-steps{counter-reset:step;list-style:none;padding:0;margin:.6rem 0}
    .guide-steps li{counter-increment:step;position:relative;padding-left:2.6rem;margin-bottom:.7rem;line-height:1.6}
    .guide-steps li::before{content:counter(step);position:absolute;left:0;top:-.1rem;width:1.8rem;height:1.8rem;background:var(--g);color:#fff;border-radius:50%;display:grid;place-items:center;font-size:.85rem;font-weight:700}
    .guide-list{margin:.5rem 0 .5rem 1.1rem}
    .guide-list li{margin:.3rem 0;line-height:1.6}
    .callout{border-radius:10px;padding:.85rem 1.05rem;margin:.9rem 0;border:1px solid;display:flex;gap:.65rem;line-height:1.6;font-size:.92rem}
    .callout .c-ico{flex:none;font-size:1.1rem;line-height:1.4}
    .callout.tip{background:#f0f8e8;border-color:#cfe6b0}
    .callout.warn{background:#fff7e6;border-color:#f2d98c}
    .callout.info{background:#eef4fb;border-color:#c7dbf0}
    .guide-tag{display:inline-block;background:#eef6e3;color:#33520f;font-weight:700;font-size:.85em;padding:.05rem .45rem;border-radius:5px}
    @media (max-width:820px){
        .guide-layout{grid-template-columns:1fr}
        .guide-toc{position:static;display:flex;flex-wrap:wrap;gap:.2rem}
        .guide-toc p{width:100%}
    }
</style>

<div class="guide">
    <header class="guide-hero">
        <h1>Panduan Penggunaan</h1>
        <p>Semua yang perlu Anda ketahui untuk mengelola website ini — dari mengisi konten sampai mengatur pengguna. Klik topik di daftar isi untuk melompat ke bagiannya.</p>
        <div class="guide-meta">
            <span>Untuk admin &amp; editor</span>
            <span>Tidak perlu keahlian teknis</span>
            <span>2 bahasa</span>
        </div>
    </header>

    <div class="guide-layout">
        <nav class="guide-toc">
            <p>Daftar Isi</p>
            <a href="#mulai">🚀 Memulai</a>
            <a href="#konten">📝 Mengelola Konten</a>
            <a href="#gambar">🖼️ Gambar &amp; Galeri</a>
            <a href="#bahasa">🌐 Dua Bahasa</a>
            <a href="#pesan">✉️ Pesan Masuk</a>
            <a href="#pengaturan">⚙️ Pengaturan</a>
            <a href="#seo">🔎 SEO</a>
            <a href="#peran">🛡️ Peran &amp; Akses</a>
            <a href="#tips">💡 Solusi Masalah</a>
        </nav>

        <div class="guide-content">

            <section id="mulai" class="guide-sec">
                <div class="guide-sec-head"><span class="guide-ico">🚀</span><h2>Memulai</h2></div>
                <p>Masuk ke panel admin melalui alamat <code>/admin/login</code> menggunakan email dan password Anda. Setelah masuk, Anda akan melihat <b>Dashboard</b> berisi ringkasan kunjungan, jumlah konten, dan skor SEO.</p>
                <h3>Navigasi</h3>
                <p>Menu di sisi kiri berisi seluruh bagian yang bisa Anda kelola. Menu yang muncul menyesuaikan <b>peran</b> Anda — jadi setiap orang hanya melihat yang menjadi tanggung jawabnya.</p>
                <div class="callout info"><span class="c-ico">ℹ️</span><div>Setiap perubahan langsung tampil di website. Bila belum berubah, tekan <b>Ctrl + F5</b> untuk memuat ulang halaman.</div></div>
            </section>

            <section id="konten" class="guide-sec">
                <div class="guide-sec-head"><span class="guide-ico">📝</span><h2>Mengelola Konten</h2></div>
                <p>Setiap jenis konten (Produk, Berita, Proyek, Layanan, dan lainnya) punya menu sendiri di bagian <b>Konten</b>.</p>
                <ol class="guide-steps">
                    <li>Pilih menu yang diinginkan, misalnya <b>Produk</b> atau <b>Berita</b>.</li>
                    <li>Klik <b>Tambah</b> untuk membuat baru, atau <b>Edit</b> pada item yang sudah ada.</li>
                    <li>Isi kolom-kolomnya, lalu klik <b>Simpan</b>.</li>
                    <li>Untuk menghapus, gunakan tombol <b>Hapus</b> pada daftar.</li>
                </ol>
                <h3>Beberapa kolom khusus</h3>
                <ul class="guide-list">
                    <li><b>Slug (URL)</b> — boleh dikosongkan; dibuat otomatis dari judul/nama.</li>
                    <li><b>Spesifikasi produk</b> — tulis satu per baris dengan format <code>Label: Nilai</code>, contoh <code>Kapasitas: 100 kg/jam</code>.</li>
                    <li><b>Isi artikel berita</b> — pisahkan antar paragraf dengan satu baris kosong.</li>
                </ul>
                <div class="callout tip"><span class="c-ico">✅</span><div>Isi setiap konten selengkap mungkin (judul jelas, deskripsi, gambar) agar tampil menarik dan mendapat skor SEO yang baik.</div></div>
            </section>

            <section id="gambar" class="guide-sec">
                <div class="guide-sec-head"><span class="guide-ico">🖼️</span><h2>Gambar &amp; Galeri</h2></div>
                <h3>Gambar produk / berita</h3>
                <p>Pada form Edit, unggah lewat kolom <b>Gambar</b>. Kosongkan bila ingin mempertahankan gambar lama. Ukuran maksimal 3 MB (format JPG, PNG, atau WebP).</p>
                <h3>Galeri proyek (banyak gambar)</h3>
                <p>Di menu <b>Proyek / Galeri</b>, kolom <b>Galeri gambar</b> bisa memilih beberapa foto sekaligus. Untuk menghapus salah satu, centang <b>Hapus</b> di bawah foto lalu Simpan. Di halaman Galeri, pengunjung mengklik kartu untuk melihat <b>slider foto</b> yang bergeser otomatis.</p>
                <div class="callout warn"><span class="c-ico">⚠️</span><div>Jika gambar yang diunggah tidak muncul (kotak kosong), minta pengembang menjalankan <code>php artisan storage:link</code> sekali di server.</div></div>
            </section>

            <section id="bahasa" class="guide-sec">
                <div class="guide-sec-head"><span class="guide-ico">🌐</span><h2>Dua Bahasa (Indonesia &amp; English)</h2></div>
                <p>Website mendukung dua bahasa. Teks tampilan (menu, tombol) sudah otomatis. Untuk <b>isi konten</b>, tiap form punya kolom versi <b>English</b> — misalnya <span class="guide-tag">Name (English)</span> <span class="guide-tag">Description (English)</span>.</p>
                <ul class="guide-list">
                    <li>Isi kolom English bila ingin konten itu tampil dalam Bahasa Inggris.</li>
                    <li>Kolom English yang <b>dikosongkan</b> otomatis memakai versi Indonesia — tidak akan ada halaman kosong.</li>
                    <li>Pengunjung berganti bahasa lewat tombol <b>ID | EN</b> di kanan atas website.</li>
                </ul>
            </section>

            <section id="pesan" class="guide-sec">
                <div class="guide-sec-head"><span class="guide-ico">✉️</span><h2>Pesan Masuk</h2></div>
                <p>Setiap pengunjung yang mengisi formulir kontak akan tercatat di menu <b>Pesan Masuk</b>. Pesan yang belum dibaca ditandai dengan angka di menu.</p>
                <ol class="guide-steps">
                    <li>Buka <b>Pesan Masuk</b> untuk melihat daftar pesan.</li>
                    <li>Klik <b>Lihat</b> untuk membaca detail lengkap.</li>
                    <li>Gunakan tombol <b>Balas via WhatsApp</b> untuk langsung menghubungi pengirim.</li>
                </ol>
            </section>

            <section id="pengaturan" class="guide-sec">
                <div class="guide-sec-head"><span class="guide-ico">⚙️</span><h2>Pengaturan Perusahaan</h2></div>
                <p>Menu <b>Pengaturan</b> berisi identitas perusahaan: nama, tagline, deskripsi, email, alamat, jam operasional, nomor WhatsApp, dan link video profil.</p>
                <div class="callout warn"><span class="c-ico">⚠️</span><div><b>Format nomor WhatsApp</b> — tulis dengan awalan <code>62</code> tanpa tanda apa pun. Contoh: nomor <code>0812-3456-7890</code> ditulis <code>6281234567890</code>. Format yang salah membuat tombol WhatsApp tidak berfungsi.</div></div>
                <p><b>Video profil:</b> tempel link YouTube pada kolom Video untuk menampilkannya di beranda.</p>
            </section>

            <section id="seo" class="guide-sec">
                <div class="guide-sec-head"><span class="guide-ico">🔎</span><h2>SEO (Mesin Pencari)</h2></div>
                <p>Menu <b>Audit SEO</b> menilai kelengkapan konten untuk mesin pencari seperti Google: judul, deskripsi, gambar, dan panjang teks. Saat menulis produk/berita, panel <b>Analisis SEO</b> di bawah form memberi skor langsung beserta saran perbaikan.</p>
                <div class="callout tip"><span class="c-ico">✅</span><div>Usahakan tiap produk/berita punya gambar, judul yang jelas, dan deskripsi yang cukup panjang untuk skor terbaik.</div></div>
            </section>

            <section id="peran" class="guide-sec">
                <div class="guide-sec-head"><span class="guide-ico">🛡️</span><h2>Peran &amp; Akses (Pengguna)</h2></div>
                <p>Anda bisa membuat beberapa akun dengan hak akses berbeda — misalnya staf yang hanya boleh mengurus berita.</p>
                <h3>Membuat peran</h3>
                <ol class="guide-steps">
                    <li>Buka menu <b>Peran &amp; Akses</b> → <b>Tambah Peran</b>.</li>
                    <li>Beri nama peran (mis. "Editor Berita").</li>
                    <li>Centang fitur yang boleh diakses — tiap modul konten bisa dipilih terpisah.</li>
                    <li>Simpan.</li>
                </ol>
                <h3>Menambah pengguna</h3>
                <ol class="guide-steps">
                    <li>Buka menu <b>Kelola User</b> → <b>Tambah Pengguna</b>.</li>
                    <li>Isi nama, email, password, dan pilih <b>Peran</b>-nya.</li>
                    <li>Simpan. Pengguna kini bisa login dengan hak akses sesuai perannya.</li>
                </ol>
                <div class="callout info"><span class="c-ico">ℹ️</span><div>Menu di panel otomatis menyesuaikan peran — setiap orang hanya melihat fitur yang diizinkan. Peran <b>Administrator</b> selalu memiliki akses penuh.</div></div>
            </section>

            <section id="tips" class="guide-sec">
                <div class="guide-sec-head"><span class="guide-ico">💡</span><h2>Solusi Masalah Umum</h2></div>
                <ul class="guide-list">
                    <li><b>Perubahan belum muncul di website</b> → tekan <b>Ctrl + F5</b>. Bila masih, minta pengembang menjalankan <code>php artisan optimize:clear</code>.</li>
                    <li><b>Gambar yang diunggah tidak tampil</b> → jalankan <code>php artisan storage:link</code> sekali di server.</li>
                    <li><b>Muncul pesan "403 / akses ditolak"</b> → peran akun Anda tidak memiliki izin untuk halaman itu. Minta Administrator menyesuaikan di <b>Peran &amp; Akses</b>.</li>
                    <li><b>Tombol WhatsApp error</b> → periksa format nomor di <b>Pengaturan</b> (harus <code>62…</code> tanpa tanda).</li>
                    <li><b>Website terasa berat</b> → kompres gambar sebelum diunggah, dan gunakan video berukuran wajar.</li>
                </ul>
                <div class="callout tip"><span class="c-ico">✅</span><div>Ganti password Anda secara berkala di menu <b>Akun</b> demi keamanan.</div></div>
            </section>

        </div>
    </div>
</div>
@endsection
