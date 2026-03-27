<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->is_active || ! $user->is_admin) {
            abort(403);
        }

        if ($user->is_super_admin) {
            return $next($request);
        }

        if (! $user->managedEvents()->wherePivot('is_active', true)->exists()) {
            abort(403);
        }

        return $next($request);
    }
}
