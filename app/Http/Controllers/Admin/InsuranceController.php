<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Insurance;
use App\Models\Patient;

class InsuranceController extends Controller
{
    public function index()
    {
        $insurances = Insurance::with('patient')->latest()->paginate(10);
        return view('admin.insurance.index', compact('insurances'));
    }

    public function create()
    {
        $patients = Patient::all();
        return view('admin.insurance.create', compact('patients'));
    }
}
