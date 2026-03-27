<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Models\LunchOption;
use App\Models\Registration;
use App\Models\SiteSetting;
use App\Models\TshirtSize;
use App\Services\TemplateEmailService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function create()
    {
        $settings = SiteSetting::query()->firstOrFail();
        $lunchOptions = LunchOption::query()->where('is_active', true)->orderBy('sort_order')->get();
        $tshirtSizes = TshirtSize::query()->where('is_active', true)->orderBy('sort_order')->get();

        return view('public.register', compact('settings', 'lunchOptions', 'tshirtSizes'));
    }

    public function store(StoreRegistrationRequest $request, TemplateEmailService $templateEmailService)
    {
        $registration = DB::transaction(function () use ($request) {
            return Registration::query()->create([
                ...$request->validated(),
                'confirmation_token' => Str::uuid()->toString(),
            ]);
        });

        $templateEmailService->sendRegistrationConfirmation($registration->load('tshirtSize', 'lunchOption'));

        return redirect()->route('public.register.success');
    }

    public function success()
    {
        $settings = SiteSetting::query()->firstOrFail();
        return view('public.register-success', compact('settings'));
    }
}
