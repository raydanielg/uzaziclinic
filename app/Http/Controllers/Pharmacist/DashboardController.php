<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pharmacist.dashboard', ['title' => 'Pharmacist Dashboard']);
    }
}
