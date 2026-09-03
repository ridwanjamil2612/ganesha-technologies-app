<?php

namespace App\Http\Middleware;

use App\Support\ContentHydrator;
use Closure;
use Illuminate\Http\Request;

class LocalizeContent
{
    public function handle(Request $request, Closure $next)
    {
        ContentHydrator::hydrate(app()->getLocale());

        return $next($request);
    }
}
