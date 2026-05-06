<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index() { return view('admin.patients.index'); }
    public function create() { return view('admin.patients.index'); }
    public function categories() { return view('admin.patients.index'); }
    public function history() { return view('admin.patients.index'); }
}
