<?php

namespace Database\Seeders;

use App\Models\ContentSection;
use Illuminate\Database\Seeder;

class ContentSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContentSection::query()->upsert([
            ['section_key' => 'highlights', 'title' => 'Conference Highlights', 'subtitle' => 'What to expect', 'body' => 'Hands-on sessions, practical district case studies, and peer collaboration.', 'button_text' => null, 'button_url' => null, 'is_enabled' => true, 'sort_order' => 1],
            ['section_key' => 'agenda_cta', 'title' => 'Agenda', 'subtitle' => null, 'body' => 'Explore keynotes, breakouts, and planning workshops.', 'button_text' => 'View Agenda', 'button_url' => '/what', 'is_enabled' => true, 'sort_order' => 2],
        ], ['section_key'], ['title', 'subtitle', 'body', 'button_text', 'button_url', 'is_enabled', 'sort_order']);
    }
}
