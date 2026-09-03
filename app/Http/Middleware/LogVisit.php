<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;

class LogVisit
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        try {
            $path = $request->path(); // '/', 'produk', 'berita/xxx'

            $skip = $request->method() !== 'GET'
                || $request->ajax()
                || $path === 'up'
                || str_starts_with($path, 'admin')
                || str_starts_with($path, 'storage')
                || str_contains($path, '.'); // aset (css/js/gambar)

            $status = method_exists($response, 'getStatusCode') ? $response->getStatusCode() : 200;

            if (! $skip && $status < 400) {
                Visit::create(['path' => '/' . ltrim($path, '/')]);
            }
        } catch (\Throwable $e) {
            // Diamkan (mis. tabel belum dimigrasikan) — jangan ganggu request.
        }

        return $response;
    }
}
