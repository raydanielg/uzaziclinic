<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function send() { return view('admin.notifications.send'); }
    public function history() { return view('admin.notifications.history'); }
    public function emailTemplates() { return view('admin.notifications.email_templates'); }
    public function smsTemplates() { return view('admin.notifications.sms_templates'); }
}
