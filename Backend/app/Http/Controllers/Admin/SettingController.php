<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');

        foreach ($data as $key => $value) {
            if ($request->hasFile($key)) {
                // Handle file upload
                $oldValue = Setting::where('key', $key)->first()?->value;
                if ($oldValue) {
                    Storage::disk('public')->delete($oldValue);
                }
                $value = $request->file($key)->store('settings', 'public');
            }

            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        \Illuminate\Support\Facades\Cache::forget('site_settings');

        return back()->with('success', 'Settings updated successfully.');
    }
}
