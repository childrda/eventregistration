<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminEventSwitchController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'event_id' => ['required', 'integer', 'exists:events,id'],
        ]);

        abort_unless($request->user()->canManageEvent((int) $data['event_id']), 403);

        session(['admin_event_id' => (int) $data['event_id']]);

        return back();
    }
}
