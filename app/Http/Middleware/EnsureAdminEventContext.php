<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminEventContext
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $events = $user->accessibleAdminEvents();

        if ($events->isEmpty()) {
            abort(403);
        }

        $sessionId = (int) session('admin_event_id', 0);
        if (! $sessionId || ! $events->contains('id', $sessionId)) {
            session(['admin_event_id' => $events->first()->id]);
        }

        return $next($request);
    }
}
