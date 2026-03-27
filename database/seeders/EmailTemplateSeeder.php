<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $variables = implode(PHP_EOL, [
            '{{event_name}}', '{{event_year}}', '{{first_name}}', '{{last_name}}',
            '{{district_name}}', '{{email}}', '{{title_role}}', '{{total_rooms_reserved}}',
            '{{tshirt_size}}', '{{food_allergies}}', '{{lunch_option}}', '{{venue_name}}',
            '{{venue_address}}', '{{event_start_date}}', '{{event_end_date}}', '{{contact_email}}',
        ]);

        EmailTemplate::query()->updateOrCreate(
            ['key' => 'registration_confirmation'],
            [
                'name' => 'Registration Confirmation',
                'subject' => 'You are registered for {{event_name}} {{event_year}}',
                'html_body' => '<h2>Thanks for registering, {{first_name}} {{last_name}}</h2><p>Your district: {{district_name}}</p><p>Event: {{event_name}} {{event_year}}</p><p>Venue: {{venue_name}}, {{venue_address}}</p><p>Questions: {{contact_email}}</p>',
                'text_body' => "Thanks for registering, {{first_name}} {{last_name}}\nDistrict: {{district_name}}\nEvent: {{event_name}} {{event_year}}\nVenue: {{venue_name}}, {{venue_address}}\nQuestions: {{contact_email}}",
                'is_active' => true,
                'from_name' => 'Virginia Cybercon',
                'reply_to_email' => 'info@vacybercon.com',
                'available_variables' => $variables,
            ]
        );
    }
}
