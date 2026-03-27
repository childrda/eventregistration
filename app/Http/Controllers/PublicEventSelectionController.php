<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class PublicEventSelectionController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'event_id' => ['required', 'integer', 'exists:events,id'],
        ]);

        $event = Event::query()->enabled()->whereKey($data['event_id'])->firstOrFail();
        session(['public_event_id' => $event->id]);

        return redirect()->route('public.home');
    }
}
