<?php

use App\Admin\Resources;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $contentKeys = array_map(fn ($k) => 'content.' . $k, array_keys(Resources::all()));

        foreach (Role::all() as $role) {
            $perms = $role->permissions ?? [];
            if (in_array('content', $perms, true)) {
                $perms = array_values(array_unique(array_merge(
                    array_values(array_diff($perms, ['content'])),
                    $contentKeys
                )));
                $role->permissions = $perms;
                $role->save();
            }
        }
    }

    public function down(): void
    {
        foreach (Role::all() as $role) {
            $perms = $role->permissions ?? [];
            $hasContent = false;
            $perms = array_values(array_filter($perms, function ($p) use (&$hasContent) {
                if (str_starts_with($p, 'content.')) { $hasContent = true; return false; }
                return true;
            }));
            if ($hasContent) {
                $perms[] = 'content';
                $role->permissions = array_values(array_unique($perms));
                $role->save();
            }
        }
    }
};
