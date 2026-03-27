<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            EventSeeder::class,
            SpeakerSeeder::class,
            FaqSeeder::class,
            TestimonialSeeder::class,
            LunchOptionSeeder::class,
            TshirtSizeSeeder::class,
            ContentSectionSeeder::class,
            PageSeeder::class,
            EmailTemplateSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}
