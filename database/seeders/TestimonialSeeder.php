<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Testimonial::query()->delete();
        Testimonial::query()->insert([
            ['quote' => 'Incredible practical value for our district team.', 'person_name' => 'Shawn K.', 'person_title' => 'Technology Director', 'sort_order' => 1, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['quote' => 'A must-attend event for K12 cybersecurity planning.', 'person_name' => 'Maria R.', 'person_title' => 'Instructional Technology Coordinator', 'sort_order' => 2, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
