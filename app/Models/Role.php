<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];

    protected $casts = [
        'permissions' => 'array',
        'is_system' => 'boolean',
    ];

    public function has(string $perm): bool
    {
        $perms = $this->permissions ?? [];

        return in_array('*', $perms, true) || in_array($perm, $perms, true);
    }
}
