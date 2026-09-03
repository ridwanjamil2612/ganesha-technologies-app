<?php

use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\BrochureController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ResourceController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
| Halaman publik
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/produk', [PageController::class, 'produk'])->name('produk');
Route::get('/produk/{slug}', [PageController::class, 'produkShow'])->name('produk.show');
Route::get('/portofolio', [PageController::class, 'portofolio'])->name('portofolio');
Route::get('/berita', [PageController::class, 'berita'])->name('berita');
Route::get('/berita/{slug}', [PageController::class, 'beritaShow'])->name('berita.show');
Route::get('/sertifikasi', [PageController::class, 'sertifikasi'])->name('sertifikasi');
Route::get('/galeri', [PageController::class, 'galeri'])->name('galeri');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');

Route::post('/kontak', [ContactController::class, 'store'])->name('kontak.store');

/*
| SEO
*/
Route::get('/sitemap.xml', [SitemapController::class, 'index']);
Route::get('/robots.txt', [SitemapController::class, 'robots']);

/*
| Ganti bahasa
*/
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['id', 'en'], true)) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang');

/*
| Autentikasi admin
*/
Route::get('/admin/login', [LoginController::class, 'show'])->name('login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('logout');

/*
| Panel admin (perlu login). Akses tiap fitur diatur izin peran (middleware perm:*)
*/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // Selalu tersedia untuk pengguna yang login
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/panduan', fn () => view('admin.help'))->name('help');
    Route::get('/akun', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/akun', [ProfileController::class, 'update'])->name('profile.update');

    // Konten
    Route::middleware('content')->group(function () {
        Route::get('/c/{resource}', [ResourceController::class, 'index'])->name('resource.index');
        Route::get('/c/{resource}/create', [ResourceController::class, 'create'])->name('resource.create');
        Route::post('/c/{resource}', [ResourceController::class, 'store'])->name('resource.store');
        Route::get('/c/{resource}/{id}/edit', [ResourceController::class, 'edit'])->name('resource.edit');
        Route::put('/c/{resource}/{id}', [ResourceController::class, 'update'])->name('resource.update');
        Route::delete('/c/{resource}/{id}', [ResourceController::class, 'destroy'])->name('resource.destroy');
    });

    // Pesan masuk
    Route::get('/pesan', [MessageController::class, 'index'])->name('messages.index')->middleware('perm:messages.view');
    Route::get('/pesan/export/csv', [MessageController::class, 'export'])->name('messages.export')->middleware('perm:messages.view');
    Route::get('/pesan/{id}', [MessageController::class, 'show'])->name('messages.show')->middleware('perm:messages.view');
    Route::delete('/pesan/{id}', [MessageController::class, 'destroy'])->name('messages.destroy')->middleware('perm:messages.delete');

    // Audit SEO
    Route::get('/seo', [SeoController::class, 'index'])->name('seo')->middleware('perm:seo');

    // Pengaturan
    Route::middleware('perm:settings')->group(function () {
        Route::get('/pengaturan', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('/pengaturan', [SettingController::class, 'update'])->name('settings.update');
    });

    // Kelola user & peran
    Route::middleware('perm:users')->group(function () {
        Route::get('/pengguna', [UserController::class, 'index'])->name('users.index');
        Route::get('/pengguna/tambah', [UserController::class, 'create'])->name('users.create');
        Route::post('/pengguna', [UserController::class, 'store'])->name('users.store');
        Route::get('/pengguna/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/pengguna/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/pengguna/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/peran', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/peran/tambah', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/peran', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/peran/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/peran/{id}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/peran/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
    });

    // Brosur (PDF)
    Route::middleware('perm:brochures')->group(function () {
        Route::get('/brosur', [BrochureController::class, 'index'])->name('brochures.index');
        Route::get('/brosur/tambah', [BrochureController::class, 'create'])->name('brochures.create');
        Route::post('/brosur', [BrochureController::class, 'store'])->name('brochures.store');
        Route::get('/brosur/{id}/edit', [BrochureController::class, 'edit'])->name('brochures.edit');
        Route::put('/brosur/{id}', [BrochureController::class, 'update'])->name('brochures.update');
        Route::delete('/brosur/{id}', [BrochureController::class, 'destroy'])->name('brochures.destroy');
    });

    // Log Aktivitas (audit)
    Route::middleware('perm:audit')->group(function () {
        Route::get('/log', [AuditLogController::class, 'index'])->name('audit.index');
        Route::post('/log/bersihkan', [AuditLogController::class, 'clear'])->name('audit.clear');
    });
});
