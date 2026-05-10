<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'today_appointments' => Appointment::where('doctor_id', auth()->id())->whereDate('appointment_date', today())->count(),
            'total_patients' => Appointment::where('doctor_id', auth()->id())->distinct('patient_id')->count(),
            'pending_reviews' => Appointment::where('doctor_id', auth()->id())->where('status', 'pending')->count(),
        ];
        
        $recent_appointments = Appointment::with('user')
            ->where('doctor_id', auth()->id())
            ->latest()
            ->limit(5)
            ->get();
            
        return view('doctor.dashboard', compact('stats', 'recent_appointments'));
    }

    public function patients() { return view('doctor.patients'); }
    public function addPrescription() { return view('doctor.prescriptions_add'); }
    public function labRequests() { return view('doctor.lab_requests'); }
    public function labResults() { return view('doctor.lab_results'); }
    public function medicalRecords() { return view('doctor.medical_records'); }
    public function schedule() { return view('doctor.schedule'); }
    public function chat() { return view('doctor.chat'); }
    public function profile() { return view('doctor.profile'); }
    public function password() { return view('doctor.password'); }
    public function reports() { return view('doctor.reports'); }
}
