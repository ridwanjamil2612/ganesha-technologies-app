<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    /** Catat satu aktivitas. Aman dipanggil di mana saja; gagal diam-diam agar tak mengganggu aksi utama. */
    public static function record(string $action, ?string $module = null, ?string $description = null): void
    {
        try {
            $user = auth()->user();
            static::create([
                'user_id'     => $user?->id,
                'user_name'   => $user?->name ?? 'Sistem',
                'action'      => $action,
                'module'      => $module,
                'description' => $description ? mb_substr($description, 0, 255) : null,
                'ip'          => request()->ip(),
                'created_at'  => now(),
            ]);
        } catch (\Throwable $e) {
            // sengaja diabaikan: pencatatan log tidak boleh menggagalkan aksi utama
        }
    }

    public static function actionLabel(string $a): string
    {
        return [
            'login'  => 'Masuk',
            'logout' => 'Keluar',
            'create' => 'Menambah',
            'update' => 'Mengubah',
            'delete' => 'Menghapus',
        ][$a] ?? ucfirst($a);
    }
}
