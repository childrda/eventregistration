<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@vacybercon.com'],
            ['name' => 'Cybercon Admin', 'password' => Hash::make('ChangeMeNow!123'), 'is_admin' => true, 'is_active' => true]
        );
    }
}
""