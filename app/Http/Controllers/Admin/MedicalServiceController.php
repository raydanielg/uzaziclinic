<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\LabTest;

class MedicalServiceController extends Controller
{
    public function prescriptions()
    {
        $prescriptions = Prescription::with(['patient', 'doctor'])->latest()->paginate(10);
        return view('admin.medical.prescriptions', compact('prescriptions'));
    }

    public function records()
    {
        $patients = Patient::withCount(['appointments', 'prescriptions'])->latest()->paginate(10);
        return view('admin.medical.records', compact('patients'));
    }

    public function labResults()
    {
        $labResults = LabTest::with(['patient', 'doctor'])->latest()->paginate(10);
        return view('admin.medical.lab_results', compact('labResults'));
    }
}
