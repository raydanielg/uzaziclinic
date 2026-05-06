<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EcommerceController extends Controller
{
    public function index() { return view('admin.store.index'); }
    public function create() { return view('admin.store.index'); }
    public function categories() { return view('admin.store.index'); }
    public function orders() { return view('admin.store.index'); }
    public function reviews() { return view('admin.store.index'); }
}
