<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index() { return view('admin.doctors.index'); }
    public function create() { return view('admin.doctors.index'); }
    public function schedules() { return view('admin.doctors.index'); }
    public function specializations() { return view('admin.doctors.index'); }
}
