<?php

namespace Database\Seeders;

use App\Models\ContentSection;
use App\Models\Event;
use Illuminate\Database\Seeder;

class ContentSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventId = Event::query()->value('id');
        if (! $eventId) {
            return;
        }

        ContentSection::query()->updateOrCreate(
            ['event_id' => $eventId, 'section_key' => 'highlights'],
            [
                'title' => 'Conference Highlights',
                'subtitle' => 'What to expect',
                'body' => 'Hands-on sessions, practical district case studies, and peer collaboration.',
                'button_text' => null,
                'button_url' => null,
                'is_enabled' => true,
                'sort_order' => 1,
            ]
        );

        ContentSection::query()->updateOrCreate(
            ['event_id' => $eventId, 'section_key' => 'agenda_cta'],
            [
                'title' => 'Agenda',
                'subtitle' => null,
                'body' => 'Explore keynotes, breakouts, and planning workshops.',
                'button_text' => 'View Agenda',
                'button_url' => '/what',
                'is_enabled' => true,
                'sort_order' => 2,
            ]
        );
    }
}
