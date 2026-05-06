<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    public function stock() { return view('admin.pharmacy.stock'); }
    public function create() { return view('admin.pharmacy.stock'); }
    public function alerts() { return view('admin.pharmacy.stock'); }
    public function suppliers() { return view('admin.pharmacy.stock'); }
    public function orders() { return view('admin.pharmacy.stock'); }
    public function expiry() { return view('admin.pharmacy.stock'); }
}
