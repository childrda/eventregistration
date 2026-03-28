<?php

use App\Http\Controllers\Admin\AdminEventSwitchController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AgendaItemController;
use App\Http\Controllers\Admin\ContentSectionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\EventManagementController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\LunchOptionController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\Admin\SentEmailController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\SpeakerController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\TshirtSizeController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicEventSelectionController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::middleware('public.event')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('public.home');
    Route::post('/select-event', [PublicEventSelectionController::class, 'store'])
        ->middleware('throttle:30,1')
        ->name('public.select-event');
    Route::get('/what', [PageController::class, 'what'])->name('public.what');
    Route::get('/when-where', [PageController::class, 'whenWhere'])->name('public.when-where');
    Route::get('/agenda', [AgendaController::class, 'index'])->name('public.agenda');
    Route::get('/agenda/{agenda_item}', [AgendaController::class, 'show'])->name('public.agenda.show');
    Route::get('/faq', [PageController::class, 'faq'])->name('public.faq');
    Route::get('/contact', [ContactController::class, 'create'])->name('public.contact');
    Route::post('/contact', [ContactController::class, 'store'])
        ->middleware('throttle:12,1')
        ->name('public.contact.store');
    Route::get('/register', [RegistrationController::class, 'create'])->name('public.register');
    Route::post('/register', [RegistrationController::class, 'store'])
        ->middleware('throttle:8,1')
        ->name('public.register.store');
    Route::get('/register/success', [RegistrationController::class, 'success'])->name('public.register.success');
});

Route::middleware('auth')->group(function () {
    Route::redirect('/dashboard', '/admin')->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->middleware(['admin.access', 'admin.event'])->group(function () {
        Route::post('/switch-event', AdminEventSwitchController::class)->name('switch-event');

        Route::get('/', DashboardController::class)->name('dashboard');
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}/event-access', [AdminUserController::class, 'removeFromEvent'])->name('users.remove-from-event');
        Route::get('/site-settings/edit', [SiteSettingController::class, 'edit'])->name('site-settings.edit');
        Route::put('/site-settings', [SiteSettingController::class, 'update'])->name('site-settings.update');

        Route::resource('agenda-items', AgendaItemController::class)->except(['show']);
        Route::resource('speakers', SpeakerController::class);
        Route::resource('pages', AdminPageController::class)->only(['index', 'edit', 'update']);
        Route::resource('faqs', AdminFaqController::class);
        Route::resource('testimonials', TestimonialController::class);
        Route::resource('content-sections', ContentSectionController::class);
        Route::resource('lunch-options', LunchOptionController::class);
        Route::resource('tshirt-sizes', TshirtSizeController::class);
        Route::resource('registrations', AdminRegistrationController::class)->except(['create', 'store', 'destroy']);
        Route::post('/registrations/{registration}/resend-confirmation', [AdminRegistrationController::class, 'resendConfirmation'])->name('registrations.resend-confirmation');
        Route::get('/registrations-export', [AdminRegistrationController::class, 'exportCsv'])->name('registrations.export');
        Route::resource('email-templates', EmailTemplateController::class)->except(['create', 'store', 'destroy']);

        Route::get('/sent-emails', [SentEmailController::class, 'index'])->name('sent-emails.index');
        Route::get('/sent-emails/{sent_email}', [SentEmailController::class, 'show'])->name('sent-emails.show');
    });

    Route::prefix('admin')->name('admin.')->middleware(['admin.access', 'admin.event', 'super.admin'])->group(function () {
        Route::resource('events', EventManagementController::class)->only(['index', 'create', 'store', 'edit', 'update']);
    });
});

require __DIR__.'/auth.php';
