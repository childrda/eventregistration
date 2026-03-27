<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->boolean('is_enabled')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
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
            $table->time('event_start_time')->nullable();
            $table->date('event_end_date')->nullable();
            $table->time('event_end_time')->nullable();
            $table->string('contact_email');
            $table->string('contact_phone')->nullable();
            $table->string('agenda_url')->nullable();
            $table->longText('agenda_html')->nullable();
            $table->string('agenda_button_text')->default('View Agenda');
            $table->string('registration_button_text')->default('Register Now');
            $table->text('footer_text')->nullable();
            $table->timestamps();
        });

        $settings = DB::table('site_settings')->orderBy('id')->first();

        if ($settings) {
            $row = (array) $settings;
            unset($row['id']);
            $row['slug'] = 'default';
            $row['is_enabled'] = true;
            $row['sort_order'] = 0;
            DB::table('events')->insert($row);
        } else {
            $now = now();
            DB::table('events')->insert([
                'slug' => 'default',
                'is_enabled' => true,
                'sort_order' => 0,
                'site_name' => 'Virginia Cybercon',
                'event_name' => 'Virginia Cybercon',
                'event_year' => (string) $now->year,
                'tagline' => 'Virginia Cybercon',
                'hero_heading' => 'Virginia Cybercon',
                'hero_subheading' => null,
                'hero_cta_text' => 'Register',
                'hero_cta_link' => '/register',
                'registration_status' => 'open',
                'registration_message' => null,
                'venue_name' => 'TBA',
                'venue_address_line_1' => '',
                'venue_address_line_2' => null,
                'venue_city' => '',
                'venue_state' => 'VA',
                'venue_zip' => '',
                'event_start_date' => $now->toDateString(),
                'event_start_time' => null,
                'event_end_date' => null,
                'event_end_time' => null,
                'contact_email' => 'info@example.com',
                'contact_phone' => null,
                'agenda_url' => null,
                'agenda_html' => null,
                'agenda_button_text' => 'View Agenda',
                'registration_button_text' => 'Register Now',
                'footer_text' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $eventId = (int) DB::table('events')->orderBy('id')->value('id');

        $tables = [
            'speakers',
            'faqs',
            'testimonials',
            'content_sections',
            'lunch_options',
            'tshirt_sizes',
            'registrations',
            'contact_messages',
            'email_templates',
            'sent_emails',
            'pages',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->unsignedBigInteger('event_id')->nullable()->after('id');
            });
            DB::table($tableName)->update(['event_id' => $eventId]);
        }

        Schema::table('registrations', function (Blueprint $table) {
            $table->dropUnique(['email']);
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropUnique(['slug']);
        });

        Schema::table('email_templates', function (Blueprint $table) {
            $table->dropUnique(['key']);
        });

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->foreign('event_id')->references('id')->on('events')->cascadeOnDelete();
            });
        }

        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            foreach ($tables as $tableName) {
                DB::statement("ALTER TABLE `{$tableName}` MODIFY `event_id` BIGINT UNSIGNED NOT NULL");
            }
        } elseif ($driver === 'sqlite') {
            // SQLite fresh installs typically use migrate:fresh; nullable is acceptable for dev
        }

        Schema::table('registrations', function (Blueprint $table) {
            $table->unique(['event_id', 'email']);
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->unique(['event_id', 'slug']);
        });

        Schema::table('email_templates', function (Blueprint $table) {
            $table->unique(['event_id', 'key']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_super_admin')->default(false)->after('is_active');
        });

        $firstUserId = DB::table('users')->orderBy('id')->value('id');
        if ($firstUserId) {
            DB::table('users')->where('id', $firstUserId)->update(['is_super_admin' => true]);
        }

        Schema::create('event_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['event_id', 'user_id']);
        });

        $adminUserIds = DB::table('users')->where('is_admin', true)->pluck('id');
        foreach ($adminUserIds as $uid) {
            $isSuper = (bool) DB::table('users')->where('id', $uid)->value('is_super_admin');
            if ($isSuper) {
                continue;
            }
            DB::table('event_user')->insert([
                'event_id' => $eventId,
                'user_id' => $uid,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::dropIfExists('site_settings');
    }

    public function down(): void
    {
        Schema::dropIfExists('event_user');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_super_admin');
        });

        Schema::table('email_templates', function (Blueprint $table) {
            $table->dropUnique(['event_id', 'key']);
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropUnique(['event_id', 'slug']);
        });

        Schema::table('registrations', function (Blueprint $table) {
            $table->dropUnique(['event_id', 'email']);
        });

        $tables = [
            'speakers',
            'faqs',
            'testimonials',
            'content_sections',
            'lunch_options',
            'tshirt_sizes',
            'registrations',
            'contact_messages',
            'email_templates',
            'sent_emails',
            'pages',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropForeign(['event_id']);
                $table->dropColumn('event_id');
            });
        }

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
            $table->time('event_start_time')->nullable();
            $table->date('event_end_date')->nullable();
            $table->time('event_end_time')->nullable();
            $table->string('contact_email');
            $table->string('contact_phone')->nullable();
            $table->string('agenda_url')->nullable();
            $table->longText('agenda_html')->nullable();
            $table->string('agenda_button_text')->default('View Agenda');
            $table->string('registration_button_text')->default('Register Now');
            $table->text('footer_text')->nullable();
            $table->timestamps();
        });

        $event = DB::table('events')->orderBy('id')->first();
        if ($event) {
            $row = (array) $event;
            unset($row['id'], $row['slug'], $row['is_enabled'], $row['sort_order']);
            DB::table('site_settings')->insert($row);
        }

        Schema::dropIfExists('events');

        Schema::table('registrations', function (Blueprint $table) {
            $table->unique('email');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->unique('slug');
        });

        Schema::table('email_templates', function (Blueprint $table) {
            $table->unique('key');
        });
    }
};
