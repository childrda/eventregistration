<?php

namespace Tests\Feature\Auth;

use Database\Seeders\EmailTemplateSeeder;
use Database\Seeders\EventSeeder;
use Database\Seeders\LunchOptionSeeder;
use Database\Seeders\TshirtSizeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function seedRegistrationDependencies(): void
    {
        $this->seed([
            EventSeeder::class,
            LunchOptionSeeder::class,
            TshirtSizeSeeder::class,
            EmailTemplateSeeder::class,
        ]);
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $this->seedRegistrationDependencies();

        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_attendee_can_submit_public_registration(): void
    {
        $this->seedRegistrationDependencies();

        $response = $this->post('/register', [
            'district_name' => 'Test District',
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
            'title_role' => 'Technology Director',
            'total_rooms_reserved' => null,
            'tshirt_size_id' => null,
            'food_allergies' => null,
            'lunch_option_id' => null,
        ]);

        $response->assertRedirect(route('public.register.success', absolute: false));
        $this->assertDatabaseHas('registrations', [
            'email' => 'jane@example.com',
            'district_name' => 'Test District',
        ]);
    }
}
