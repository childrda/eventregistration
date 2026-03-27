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
        Schema::table('site_settings', function (Blueprint $table) {
            $table->time('event_start_time')->nullable()->after('event_start_date');
            $table->time('event_end_time')->nullable()->after('event_end_date');
            $table->longText('agenda_html')->nullable()->after('agenda_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['event_start_time', 'event_end_time', 'agenda_html']);
        });
    }
};
