<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use App\Models\SiteSetting;

class ContactController extends Controller
{
    public function create()
    {
        $settings = SiteSetting::query()->firstOrFail();
        return view('public.contact', compact('settings'));
    }

    public function store(StoreContactMessageRequest $request)
    {
        ContactMessage::query()->create($request->validated());
        return back()->with('success', 'Thanks! Your message was sent.');
    }
}
