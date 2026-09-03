<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        $u = $request->user();
        abort_unless($u && ($u->role ?? 'admin') === 'admin', 403, 'Halaman ini khusus Administrator.');

        return $next($request);
    }
}
