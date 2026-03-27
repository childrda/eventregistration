<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'site_name' => ['required', 'string', 'max:255'],
            'event_name' => ['required', 'string', 'max:255'],
            'event_year' => ['required', 'string', 'max:8'],
            'tagline' => ['required', 'string', 'max:255'],
            'hero_heading' => ['required', 'string', 'max:255'],
            'hero_subheading' => ['nullable', 'string'],
            'hero_cta_text' => ['required', 'string', 'max:255'],
            'hero_cta_link' => ['required', 'string', 'max:255'],
            'registration_status' => ['required', 'in:open,closed,waitlist'],
            'registration_message' => ['nullable', 'string'],
            'venue_name' => ['required', 'string', 'max:255'],
            'venue_address_line_1' => ['required', 'string', 'max:255'],
            'venue_address_line_2' => ['nullable', 'string', 'max:255'],
            'venue_city' => ['required', 'string', 'max:255'],
            'venue_state' => ['required', 'string', 'max:100'],
            'venue_zip' => ['required', 'string', 'max:20'],
            'event_start_date' => ['required', 'date'],
            'event_start_time' => ['nullable', 'date_format:H:i'],
            'event_end_date' => ['nullable', 'date'],
            'event_end_time' => ['nullable', 'date_format:H:i'],
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'agenda_url' => ['nullable', 'url', 'max:255'],
            'agenda_html' => ['nullable', 'string'],
            'agenda_button_text' => ['required', 'string', 'max:255'],
            'registration_button_text' => ['required', 'string', 'max:255'],
            'footer_text' => ['nullable', 'string'],
        ];
    }
}
