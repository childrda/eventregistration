<?php

namespace App\Providers;

use App\Models\AgendaItem;
use App\Models\ContentSection;
use App\Models\EmailTemplate;
use App\Models\Event;
use App\Models\Faq;
use App\Models\LunchOption;
use App\Models\Page;
use App\Models\Registration;
use App\Models\SentEmail;
use App\Models\Speaker;
use App\Models\Testimonial;
use App\Models\TshirtSize;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.force_https')) {
            URL::forceScheme('https');
        }

        $scoped = [
            'speaker' => Speaker::class,
            'faq' => Faq::class,
            'testimonial' => Testimonial::class,
            'content_section' => ContentSection::class,
            'lunch_option' => LunchOption::class,
            'tshirt_size' => TshirtSize::class,
            'page' => Page::class,
            'email_template' => EmailTemplate::class,
            'registration' => Registration::class,
            'sent_email' => SentEmail::class,
        ];

        foreach ($scoped as $param => $modelClass) {
            Route::bind($param, function ($value) use ($modelClass) {
                return $modelClass::query()
                    ->where('event_id', session('admin_event_id'))
                    ->whereKey($value)
                    ->firstOrFail();
            });
        }

        Route::bind('agenda_item', function ($value) {
            $eventId = request()->routeIs('admin.*')
                ? session('admin_event_id')
                : session('public_event_id');

            return AgendaItem::query()
                ->where('event_id', $eventId)
                ->whereKey($value)
                ->firstOrFail();
        });

        View::composer('layouts.public', function ($view) {
            $id = session('public_event_id');
            $settings = $id ? Event::query()->enabled()->whereKey($id)->first() : null;
            $showAgendaNav = $settings && $settings->hasAgendaContent();
            $view->with(['settings' => $settings, 'showAgendaNav' => $showAgendaNav]);
        });
    }
}
