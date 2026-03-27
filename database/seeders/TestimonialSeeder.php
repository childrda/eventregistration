<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
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

        Testimonial::query()->where('event_id', $eventId)->delete();
        Testimonial::query()->insert([
            ['event_id' => $eventId, 'quote' => 'Incredible practical value for our district team.', 'person_name' => 'Shawn K.', 'person_title' => 'Technology Director', 'sort_order' => 1, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['event_id' => $eventId, 'quote' => 'A must-attend event for K12 cybersecurity planning.', 'person_name' => 'Maria R.', 'person_title' => 'Instructional Technology Coordinator', 'sort_order' => 2, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
