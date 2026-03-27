<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\SentEmail;

class SentEmailController extends Controller
{
    public function index()
    {
        $eventId = (int) session('admin_event_id');

        $query = SentEmail::query()
            ->where('event_id', $eventId)
            ->with(['registration', 'emailTemplate'])
            ->latest();

        if ($template = request('email_template_id')) {
            $query->where('email_template_id', $template);
        }
        if ($email = request('to_email')) {
            $query->where('to_email', 'like', "%{$email}%");
        }
        if ($status = request('status')) {
            $query->where('status', $status);
        }

        return view('admin.sent-emails.index', [
            'sentEmails' => $query->paginate(25)->withQueryString(),
            'templates' => EmailTemplate::query()->forAdminEvent()->orderBy('name')->get(),
        ]);
    }

    public function show(SentEmail $sent_email)
    {
        $sent_email->load(['registration', 'emailTemplate']);

        return view('admin.sent-emails.show', ['sentEmail' => $sent_email]);
    }
}
