<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSiteSettingRequest;
use App\Models\SiteSetting;

class SiteSettingController extends Controller
{
    public function edit()
    {
        $siteSetting = SiteSetting::query()->firstOrFail();
        return view('admin.site-settings.edit', compact('siteSetting'));
    }

    public function update(UpdateSiteSettingRequest $request)
    {
        $siteSetting = SiteSetting::query()->firstOrFail();
        $siteSetting->update($request->validated());
        return back()->with('success', 'Site settings updated.');
    }
}
