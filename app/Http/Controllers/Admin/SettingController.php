<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function general() { return view('admin.settings.general'); }
    public function email() { return view('admin.settings.general'); }
    public function sms() { return view('admin.settings.general'); }
    public function gateways() { return view('admin.settings.general'); }
    public function backup() { return view('admin.settings.general'); }
}
