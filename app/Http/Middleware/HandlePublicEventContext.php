<?php

namespace App\Http\Middleware;

use App\Models\Event;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandlePublicEventContext
{
    public function handle(Request $request, Closure $next): Response
    {
        $enabled = Event::query()->enabled()->orderBy('sort_order')->orderBy('id')->get();

        if ($enabled->isEmpty()) {
            if (! $request->routeIs('public.home')) {
                abort(503, 'No events are available.');
            }

            return $next($request);
        }

        if ($enabled->count() === 1) {
            session(['public_event_id' => $enabled->first()->id]);
        }

        $exempt = $request->routeIs('public.home', 'public.select-event');

        if (! $exempt && $enabled->count() > 1 && ! session('public_event_id')) {
            return redirect()
                ->route('public.home')
                ->with('info', 'Please choose an event to continue.');
        }

        $publicId = (int) session('public_event_id', 0);
        if ($publicId && ! $enabled->contains('id', $publicId)) {
            session()->forget('public_event_id');
            if ($enabled->count() > 1) {
                return redirect()->route('public.home');
            }
            session(['public_event_id' => $enabled->first()->id]);
        }

        return $next($request);
    }
}
