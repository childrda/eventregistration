<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UpdateEmailTemplateRequest;
use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\Registration;
use App\Models\SiteSetting;
use App\Services\TemplateEmailService;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $emailTemplates = EmailTemplate::query()->orderBy('name')->paginate(20);
        return view('admin.email-templates.index', compact('emailTemplates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store() {}

    /**
     * Display the specified resource.
     */
    public function show(EmailTemplate $email_template, TemplateEmailService $templateEmailService)
    {
        $sampleRegistration = Registration::query()->with(['tshirtSize', 'lunchOption'])->first();
        $settings = SiteSetting::query()->first();
        $preview = '';

        if ($sampleRegistration && $settings) {
            $preview = $templateEmailService->merge($email_template->html_body ?? $email_template->text_body ?? '', $templateEmailService->registrationVariables($sampleRegistration, $settings));
        }

        return view('admin.email-templates.show', ['emailTemplate' => $email_template, 'preview' => $preview]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmailTemplate $email_template)
    {
        return view('admin.email-templates.edit', ['emailTemplate' => $email_template]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmailTemplateRequest $request, EmailTemplate $email_template)
    {
        $email_template->update($request->validated());
        return redirect()->route('admin.email-templates.index')->with('success', 'Email template updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailTemplate $email_template) {}
}
