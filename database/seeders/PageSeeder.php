<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
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

        Page::query()->updateOrCreate(
            ['event_id' => $eventId, 'slug' => 'what'],
            [
                'title' => 'What',
                'intro' => 'Conference overview',
                'body' => 'Virginia Cybercon brings together district leaders and cybersecurity practitioners.',
                'is_active' => true,
            ]
        );

        Page::query()->updateOrCreate(
            ['event_id' => $eventId, 'slug' => 'when-where'],
            [
                'title' => 'When & Where',
                'intro' => 'Venue and timing',
                'body' => 'Hosted at the Holiday Inn in Richmond, VA.',
                'is_active' => true,
            ]
        );
    }
}
