<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\Invoice;
use App\Models\LabRequest;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $patientId = $user->id;

        $totalAppointments  = Appointment::where('user_id', $patientId)->count();
        $totalPrescriptions = Prescription::where('patient_id', $patientId)->count();
        $labResults         = LabRequest::where('patient_id', $patientId)->where('status', 'completed')->count();
        $pendingBills       = Invoice::where('patient_id', $patientId)->where('status', 'pending')->count();

        $stats = [
            'total_appointments'  => $totalAppointments,
            'total_prescriptions' => $totalPrescriptions,
            'lab_results'         => $labResults,
            'pending_bills'       => $pendingBills,
        ];

        $upcomingAppointments = Appointment::with('doctor')
            ->where('user_id', $patientId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('appointment_date')
            ->limit(5)
            ->get();

        $activePrescriptions = Prescription::with('medicine')
            ->where('patient_id', $patientId)
            ->latest()
            ->limit(5)
            ->get();

        return view('patient.dashboard', compact('stats', 'upcomingAppointments', 'activePrescriptions'));
    }
}
