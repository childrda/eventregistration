<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name');
            $table->string('event_name');
            $table->string('event_year', 8);
            $table->string('tagline');
            $table->string('hero_heading');
            $table->text('hero_subheading')->nullable();
            $table->string('hero_cta_text');
            $table->string('hero_cta_link');
            $table->string('registration_status', 20)->default('open');
            $table->text('registration_message')->nullable();
            $table->string('venue_name');
            $table->string('venue_address_line_1');
            $table->string('venue_address_line_2')->nullable();
            $table->string('venue_city');
            $table->string('venue_state', 50);
            $table->string('venue_zip', 20);
            $table->date('event_start_date');
            $table->date('event_end_date')->nullable();
            $table->string('contact_email');
            $table->string('contact_phone')->nullable();
            $table->string('agenda_url')->nullable();
            $table->string('agenda_button_text')->default('View Agenda');
            $table->string('registration_button_text')->default('Register Now');
            $table->text('footer_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
