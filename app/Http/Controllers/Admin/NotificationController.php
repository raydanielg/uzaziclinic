<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function send() { return view('admin.notifications.send'); }
    public function history() { return view('admin.notifications.send'); }
    public function emailTemplates() { return view('admin.notifications.send'); }
    public function smsTemplates() { return view('admin.notifications.send'); }
}
