<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LabController extends Controller
{
    public function catalog() { return view('admin.lab.catalog'); }
    public function results() { return view('admin.lab.catalog'); }
    public function equipment() { return view('admin.lab.catalog'); }
    public function reports() { return view('admin.lab.catalog'); }
}
