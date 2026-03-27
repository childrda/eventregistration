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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('district_name');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('title_role');
            $table->unsignedInteger('total_rooms_reserved')->nullable();
            $table->foreignId('tshirt_size_id')->nullable()->constrained('tshirt_sizes')->nullOnDelete();
            $table->text('food_allergies')->nullable();
            $table->foreignId('lunch_option_id')->nullable()->constrained('lunch_options')->nullOnDelete();
            $table->string('status', 20)->default('registered');
            $table->string('confirmation_token')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
