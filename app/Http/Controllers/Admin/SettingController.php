<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Setting;

class SettingController extends Controller
{
    public function general()
    {
        $settings = Setting::where('group', 'general')->pluck('value', 'key')->all();
        return view('admin.settings.general', compact('settings'));
    }

    public function email()
    {
        $settings = Setting::where('group', 'email')->pluck('value', 'key')->all();
        return view('admin.settings.email', compact('settings'));
    }

    public function sms()
    {
        $settings = Setting::where('group', 'sms')->pluck('value', 'key')->all();
        return view('admin.settings.sms', compact('settings'));
    }

    public function gateways()
    {
        $settings = Setting::where('group', 'gateways')->pluck('value', 'key')->all();
        return view('admin.settings.gateways', compact('settings'));
    }

    public function backup()
    {
        $settings = Setting::where('group', 'backup')->pluck('value', 'key')->all();
        return view('admin.settings.backup', compact('settings'));
    }

    public function update(Request $request)
    {
        $group = $request->input('group', 'general');
        $data = $request->except(['_token', 'group']);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => $group]
            );
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Settings updated successfully!']);
        }

        return back()->with('success', 'Settings updated successfully!');
    }
}
