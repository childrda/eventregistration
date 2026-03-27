<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
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

        Faq::query()->where('event_id', $eventId)->delete();
        Faq::query()->insert([
            ['event_id' => $eventId, 'question' => 'Who should attend?', 'answer' => 'District technology and cybersecurity leaders.', 'sort_order' => 1, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['event_id' => $eventId, 'question' => 'Is there a registration limit?', 'answer' => 'One registration per attendee email address.', 'sort_order' => 2, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
