<?php

use App\Http\Middleware\ContentPermission;
use App\Http\Middleware\LocalizeContent;
use App\Http\Middleware\LogVisit;
use App\Http\Middleware\PermissionMiddleware;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->appendToGroup('web', [LogVisit::class, SetLocale::class, LocalizeContent::class]);
        $middleware->alias([
            'perm' => PermissionMiddleware::class,
            'content' => ContentPermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
