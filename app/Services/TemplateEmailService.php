<?php

namespace App\Services;

use App\Mail\RegistrationConfirmationMail;
use App\Models\EmailTemplate;
use App\Models\Registration;
use App\Models\SentEmail;
use App\Models\SiteSetting;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Throwable;

class TemplateEmailService
{
    public function sendRegistrationConfirmation(Registration $registration): SentEmail
    {
        $template = EmailTemplate::query()->where('key', 'registration_confirmation')->firstOrFail();
        $settings = SiteSetting::query()->firstOrFail();

        $vars = $this->registrationVariables($registration, $settings);
        $subject = $this->merge($template->subject, $vars);
        $htmlBody = $this->merge($template->html_body ?? '', $vars);
        $textBody = $this->merge($template->text_body ?? '', $vars);

        $sentEmail = SentEmail::query()->create([
            'email_template_id' => $template->id,
            'registration_id' => $registration->id,
            'to_email' => $registration->email,
            'subject' => $subject,
            'html_body' => $htmlBody ?: null,
            'text_body' => $textBody ?: null,
            'status' => 'failed',
        ]);

        if (! $template->is_active) {
            $sentEmail->update(['error_message' => 'Template is disabled.']);
            return $sentEmail;
        }

        try {
            Mail::to($registration->email)->send(new RegistrationConfirmationMail(
                $subject,
                $htmlBody,
                $textBody,
                Arr::get($template, 'from_name'),
                Arr::get($template, 'reply_to_email')
            ));

            $sentEmail->update([
                'status' => 'sent',
                'sent_at' => now(),
                'error_message' => null,
            ]);
        } catch (Throwable $e) {
            $sentEmail->update(['error_message' => $e->getMessage()]);
            report($e);
        }

        return $sentEmail;
    }

    public function registrationVariables(Registration $registration, SiteSetting $settings): array
    {
        $venueAddress = collect([
            $settings->venue_address_line_1,
            $settings->venue_address_line_2,
            trim("{$settings->venue_city}, {$settings->venue_state} {$settings->venue_zip}"),
        ])->filter()->implode(', ');

        return [
            'event_name' => $settings->event_name,
            'event_year' => $settings->event_year,
            'first_name' => $registration->first_name,
            'last_name' => $registration->last_name,
            'district_name' => $registration->district_name,
            'email' => $registration->email,
            'title_role' => $registration->title_role,
            'total_rooms_reserved' => (string) ($registration->total_rooms_reserved ?? ''),
            'tshirt_size' => optional($registration->tshirtSize)->name ?? '',
            'food_allergies' => $registration->food_allergies ?? '',
            'lunch_option' => optional($registration->lunchOption)->name ?? '',
            'venue_name' => $settings->venue_name,
            'venue_address' => $venueAddress,
            'event_start_date' => optional($settings->event_start_date)->format('F j, Y') ?? '',
            'event_end_date' => optional($settings->event_end_date)->format('F j, Y') ?? '',
            'contact_email' => $settings->contact_email,
        ];
    }

    public function merge(string $content, array $variables): string
    {
        foreach ($variables as $key => $value) {
            $content = str_replace('{{'.$key.'}}', e((string) $value), $content);
        }

        return $content;
    }
}

