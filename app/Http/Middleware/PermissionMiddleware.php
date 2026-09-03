<?php

namespace App\Http\Middleware;

use App\Support\Perms;
use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, string $perm)
    {
        abort_unless(Perms::allows($request->user(), $perm), 403, 'Peran Anda tidak memiliki akses ke halaman ini.');

        return $next($request);
    }
}
