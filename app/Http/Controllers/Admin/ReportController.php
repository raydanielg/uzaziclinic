<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function sales() { return view('admin.reports.sales'); }
    public function patients() { return view('admin.reports.sales'); }
    public function doctors() { return view('admin.reports.sales'); }
    public function stock() { return view('admin.reports.sales'); }
    public function revenue() { return view('admin.reports.sales'); }
    public function appointments() { return view('admin.reports.sales'); }
}
