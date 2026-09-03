<?php

namespace App\Support;

use App\Admin\Resources;
use App\Models\Role;

class Perms
{
    /** Daftar semua izin fitur (key => label). Konten dipecah per modul. */
    public static function all(): array
    {
        $content = [];
        foreach (Resources::all() as $key => $def) {
            $content['content.' . $key] = 'Kelola ' . $def['label'];
        }

        return $content + [
            'messages.view'   => 'Lihat Pesan Masuk',
            'messages.delete' => 'Hapus Pesan Masuk',
            'seo'             => 'Audit SEO',
            'brochures'       => 'Kelola Brosur (PDF)',
            'settings'        => 'Pengaturan Perusahaan',
            'users'           => 'Kelola User & Peran',
            'audit'           => 'Lihat Log Aktivitas',
        ];
    }

    public static function keys(): array
    {
        return array_keys(self::all());
    }

    protected static array $cache = [];

    public static function allows($user, string $key): bool
    {
        if (! $user || ! $user->role_id) {
            return false;
        }
        $rid = $user->role_id;
        if (! array_key_exists($rid, self::$cache)) {
            $role = Role::find($rid);
            self::$cache[$rid] = $role ? ($role->permissions ?? []) : [];
        }
        $perms = self::$cache[$rid];

        return in_array('*', $perms, true) || in_array($key, $perms, true);
    }
}
