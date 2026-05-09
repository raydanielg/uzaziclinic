<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('user')->latest()->paginate(10);
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create() { return view('admin.doctors.index'); }
    public function schedules() { return view('admin.doctors.index'); }
    public function specializations() { return view('admin.doctors.index'); }
}
