<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index() { return view('admin.appointments.index'); }
    public function today() { return view('admin.appointments.index'); }
    public function upcoming() { return view('admin.appointments.index'); }
    public function cancelled() { return view('admin.appointments.index'); }
}
