<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('content_sections', function (Blueprint $table) {
            $table->dropUnique(['section_key']);
            $table->unique(['event_id', 'section_key']);
        });
    }

    public function down(): void
    {
        Schema::table('content_sections', function (Blueprint $table) {
            $table->dropUnique(['event_id', 'section_key']);
            $table->unique('section_key');
        });
    }
};
