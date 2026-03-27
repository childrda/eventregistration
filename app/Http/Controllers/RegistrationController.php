<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Models\Event;
use App\Models\LunchOption;
use App\Models\Registration;
use App\Models\TshirtSize;
use App\Services\TemplateEmailService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function create()
    {
        $eventId = (int) session('public_event_id');
        $settings = Event::query()->enabled()->whereKey($eventId)->firstOrFail();
        $lunchOptions = LunchOption::query()
            ->where('event_id', $eventId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        $tshirtSizes = TshirtSize::query()
            ->where('event_id', $eventId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('public.register', compact('settings', 'lunchOptions', 'tshirtSizes'));
    }

    public function store(StoreRegistrationRequest $request, TemplateEmailService $templateEmailService)
    {
        $eventId = (int) session('public_event_id');

        $registration = DB::transaction(function () use ($request, $eventId) {
            return Registration::query()->create([
                ...$request->validated(),
                'event_id' => $eventId,
                'confirmation_token' => Str::uuid()->toString(),
            ]);
        });

        $templateEmailService->sendRegistrationConfirmation($registration->load('tshirtSize', 'lunchOption', 'event'));

        return redirect()->route('public.register.success');
    }

    public function success()
    {
        $eventId = (int) session('public_event_id');
        $settings = Event::query()->enabled()->whereKey($eventId)->firstOrFail();

        return view('public.register-success', compact('settings'));
    }
}
