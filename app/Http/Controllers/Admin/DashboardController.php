<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Registration;
use App\Models\SentEmail;
use App\Models\Speaker;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'registrationCount' => Registration::query()->count(),
            'speakerCount' => Speaker::query()->count(),
            'unreadContactCount' => ContactMessage::query()->where('is_read', false)->count(),
            'failedEmailCount' => SentEmail::query()->where('status', 'failed')->count(),
        ]);
    }
}
