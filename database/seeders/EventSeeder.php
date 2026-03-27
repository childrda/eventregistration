<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::query()->updateOrCreate(
            ['slug' => 'default'],
            [
                'is_enabled' => true,
                'sort_order' => 0,
                'site_name' => 'Virginia Cybercon',
                'event_name' => 'Virginia Cybercon',
                'event_year' => date('Y'),
                'tagline' => 'Empowering K12 cybersecurity leadership across Virginia',
                'hero_heading' => 'Virginia Cybercon',
                'hero_subheading' => 'A focused conference for K12 technology leaders, security professionals, and district teams.',
                'hero_cta_text' => 'Register for Cybercon',
                'hero_cta_link' => '/register',
                'registration_status' => 'open',
                'registration_message' => 'Registration is open now.',
                'venue_name' => 'Holiday Inn',
                'venue_address_line_1' => '1021 Koger Center Blvd',
                'venue_address_line_2' => null,
                'venue_city' => 'Richmond',
                'venue_state' => 'VA',
                'venue_zip' => '23235',
                'event_start_date' => now()->addMonths(2)->toDateString(),
                'event_start_time' => '09:00:00',
                'event_end_date' => now()->addMonths(2)->toDateString(),
                'event_end_time' => '15:30:00',
                'contact_email' => 'info@vacybercon.com',
                'contact_phone' => null,
                'agenda_url' => 'https://www.vacybercon.com',
                'agenda_html' => '<h2>Sample Agenda</h2><p>Use Site Settings to customize this agenda page.</p><ul><li>9:00 AM - Opening Session</li><li>10:00 AM - Breakouts</li><li>12:00 PM - Lunch</li><li>1:00 PM - Workshops</li></ul>',
                'agenda_button_text' => 'View Agenda',
                'registration_button_text' => 'Register Now',
                'footer_text' => 'Virginia Cybercon',
            ]
        );
    }
}
