<?php

use App\Http\Middleware\EnsureAdminAccess;
use App\Http\Middleware\EnsureAdminEventContext;
use App\Http\Middleware\EnsureSuperAdmin;
use App\Http\Middleware\HandlePublicEventContext;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $proxies = env('TRUSTED_PROXIES', '*');
        $at = $proxies === '*' ? '*' : array_values(array_filter(array_map('trim', explode(',', $proxies))));
        $middleware->trustProxies(
            at: $at === [] ? '*' : $at,
            headers: Request::HEADER_X_FORWARDED_FOR
                | Request::HEADER_X_FORWARDED_HOST
                | Request::HEADER_X_FORWARDED_PORT
                | Request::HEADER_X_FORWARDED_PROTO,
        );

        $middleware->alias([
            'admin.access' => EnsureAdminAccess::class,
            'admin.event' => EnsureAdminEventContext::class,
            'super.admin' => EnsureSuperAdmin::class,
            'public.event' => HandlePublicEventContext::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
