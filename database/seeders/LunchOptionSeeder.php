<?php

namespace Database\Seeders;

use App\Models\LunchOption;
use Illuminate\Database\Seeder;

class LunchOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LunchOption::query()->delete();
        LunchOption::query()->insert([
            ['name' => 'Turkey Sandwich', 'description' => null, 'sort_order' => 1, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Vegetarian Wrap', 'description' => null, 'sort_order' => 2, 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
