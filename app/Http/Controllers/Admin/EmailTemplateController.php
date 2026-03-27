<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateEmailTemplateRequest;
use App\Models\EmailTemplate;
use App\Models\Event;
use App\Models\Registration;
use App\Services\TemplateEmailService;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $emailTemplates = EmailTemplate::query()->forAdminEvent()->orderBy('name')->paginate(20);

        return view('admin.email-templates.index', compact('emailTemplates'));
    }

    public function create() {}

    public function store() {}

    public function show(EmailTemplate $email_template, TemplateEmailService $templateEmailService)
    {
        $eventId = (int) session('admin_event_id');
        $sampleRegistration = Registration::query()
            ->where('event_id', $eventId)
            ->with(['tshirtSize', 'lunchOption'])
            ->first();
        $settings = Event::query()->find($eventId);
        $preview = '';

        if ($sampleRegistration && $settings) {
            $preview = $templateEmailService->merge(
                $email_template->html_body ?? $email_template->text_body ?? '',
                $templateEmailService->registrationVariables($sampleRegistration, $settings)
            );
        }

        return view('admin.email-templates.show', ['emailTemplate' => $email_template, 'preview' => $preview]);
    }

    public function edit(EmailTemplate $email_template)
    {
        return view('admin.email-templates.edit', ['emailTemplate' => $email_template]);
    }

    public function update(UpdateEmailTemplateRequest $request, EmailTemplate $email_template)
    {
        $email_template->update($request->validated());

        return redirect()->route('admin.email-templates.index')->with('success', 'Email template updated.');
    }

    public function destroy(EmailTemplate $email_template) {}
}
