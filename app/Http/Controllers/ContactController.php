<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use App\Models\Event;

class ContactController extends Controller
{
    public function create()
    {
        $eventId = (int) session('public_event_id');
        $settings = Event::query()->enabled()->whereKey($eventId)->firstOrFail();

        return view('public.contact', compact('settings'));
    }

    public function store(StoreContactMessageRequest $request)
    {
        ContactMessage::query()->create([
            ...$request->validated(),
            'event_id' => session('public_event_id'),
        ]);

        return back()->with('success', 'Thanks! Your message was sent.');
    }
}
