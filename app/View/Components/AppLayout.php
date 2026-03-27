<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $view = view('layouts.app');

        if (Auth::check() && request()->routeIs('admin.*')) {
            $user = Auth::user();
            $accessibleAdminEvents = $user->accessibleAdminEvents();
            $currentId = (int) session('admin_event_id');
            $currentAdminEvent = $accessibleAdminEvents->firstWhere('id', $currentId)
                ?? $accessibleAdminEvents->first();
            $view->with(compact('accessibleAdminEvents', 'currentAdminEvent'));
        }

        return $view;
    }
}
