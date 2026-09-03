<?php

namespace App\Http\Middleware;

use App\Support\Perms;
use Closure;
use Illuminate\Http\Request;

class ContentPermission
{
    public function handle(Request $request, Closure $next)
    {
        $resource = $request->route('resource');
        abort_unless(Perms::allows($request->user(), 'content.' . $resource), 403, 'Peran Anda tidak memiliki akses ke konten ini.');

        return $next($request);
    }
}
