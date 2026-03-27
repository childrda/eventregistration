<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\TshirtSize;
use Illuminate\Database\Seeder;

class TshirtSizeSeeder extends Seeder
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

        TshirtSize::query()->where('event_id', $eventId)->delete();
        foreach (['S', 'M', 'L', 'XL', '2XL'] as $idx => $size) {
            TshirtSize::query()->create([
                'event_id' => $eventId,
                'name' => $size,
                'sort_order' => $idx + 1,
                'is_active' => true,
            ]);
        }
    }
}
