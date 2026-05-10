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

    public function patients()
    {
        $patients = Appointment::with('user')
            ->where('doctor_id', auth()->id())
            ->select('patient_id')
            ->distinct()
            ->get()
            ->map(function($appointment) {
                return $appointment->user;
            })
            ->filter();

        return view('doctor.patients', compact('patients'));
    }

    public function patientDetails($id)
    {
        $patient = \App\Models\User::findOrFail($id);
        $appointments = Appointment::where('patient_id', $id)
            ->where('doctor_id', auth()->id())
            ->latest()
            ->get();
            
        $medical_records = \App\Models\MedicalRecord::where('patient_id', $id)->latest()->get();
        
        return view('doctor.patient_details', compact('patient', 'appointments', 'medical_records'));
    }
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
