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
        $eventId = (int) session('admin_event_id');

        return view('admin.dashboard', [
            'registrationCount' => Registration::query()->where('event_id', $eventId)->count(),
            'speakerCount' => Speaker::query()->where('event_id', $eventId)->count(),
            'unreadContactCount' => ContactMessage::query()
                ->where('event_id', $eventId)
                ->where('is_read', false)
                ->count(),
            'failedEmailCount' => SentEmail::query()
                ->where('event_id', $eventId)
                ->where('status', 'failed')
                ->count(),
        ]);
    }
}
