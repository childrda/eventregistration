<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Page::query()->upsert([
            ['slug' => 'what', 'title' => 'What', 'intro' => 'Conference overview', 'body' => 'Virginia Cybercon brings together district leaders and cybersecurity practitioners.', 'is_active' => true],
            ['slug' => 'when-where', 'title' => 'When & Where', 'intro' => 'Venue and timing', 'body' => 'Hosted at the Holiday Inn in Richmond, VA.', 'is_active' => true],
        ], ['slug'], ['title', 'intro', 'body', 'is_active']);
    }
}
