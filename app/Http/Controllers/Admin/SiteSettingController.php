<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSiteSettingRequest;
use App\Models\Event;

class SiteSettingController extends Controller
{
    public function edit()
    {
        $siteSetting = Event::query()->findOrFail((int) session('admin_event_id'));

        return view('admin.site-settings.edit', ['siteSetting' => $siteSetting]);
    }

    public function update(UpdateSiteSettingRequest $request)
    {
        $siteSetting = Event::query()->findOrFail((int) session('admin_event_id'));
        $siteSetting->update($request->validated());

        return back()->with('success', 'Site settings updated.');
    }
}
