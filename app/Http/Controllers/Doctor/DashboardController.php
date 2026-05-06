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
        
        return view('doctor.dashboard', compact('stats'));
    }
}
