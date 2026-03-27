<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Speaker;
use Illuminate\Database\Seeder;

class SpeakerSeeder extends Seeder
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

        Speaker::query()->where('event_id', $eventId)->delete();
        Speaker::query()->insert([
            ['event_id' => $eventId, 'name' => 'Dr. Alex Carter', 'title' => 'Keynote Speaker', 'subtitle' => 'State Cybersecurity Advisor', 'bio' => 'Leading statewide K12 cyber resilience initiatives.', 'sort_order' => 1, 'is_featured' => 1, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['event_id' => $eventId, 'name' => 'Jordan Miles', 'title' => 'Presenter', 'subtitle' => 'District CISO', 'bio' => 'Practical tabletop strategies for school districts.', 'sort_order' => 2, 'is_featured' => 0, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
