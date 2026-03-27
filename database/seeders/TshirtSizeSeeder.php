<?php

namespace Database\Seeders;

use App\Models\TshirtSize;
use Illuminate\Database\Seeder;

class TshirtSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TshirtSize::query()->delete();
        foreach (['S', 'M', 'L', 'XL', '2XL'] as $idx => $size) {
            TshirtSize::query()->create([
                'name' => $size,
                'sort_order' => $idx + 1,
                'is_active' => true,
            ]);
        }
    }
}
