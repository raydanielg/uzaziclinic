<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::with('user')->latest()->paginate(10);
        return view('admin.patients.index', compact('patients'));
    }

    public function create() { return view('admin.patients.index'); }
    public function categories() { return view('admin.patients.index'); }
    public function history() { return view('admin.patients.index'); }
}
