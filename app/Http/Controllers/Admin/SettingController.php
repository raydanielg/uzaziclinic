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

    public function email() { return $this->general(); }
    public function sms() { return $this->general(); }
    public function gateways() { return $this->general(); }
    public function backup() { return $this->general(); }
}
