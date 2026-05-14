<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'today_appointments' => Appointment::whereDate('appointment_date', today())->count(),
            'pending_registrations' => User::whereHas('role', function($q) { $q->where('name', 'customer'); })
                ->whereDate('created_at', today())->count(),
            'active_doctors' => User::whereHas('role', function($q) { $q->where('name', 'doctor'); })
                ->where('status', 'active')->count(),
            'total_patients' => User::whereHas('role', function($q) { $q->where('name', 'customer'); })->count(),
        ];

        $recent_appointments = Appointment::with('user', 'doctor')->latest()->limit(10)->get();

        return view('receptionist.dashboard', compact('stats', 'recent_appointments'));
    }

    public function appointments()
    {
        $appointments = Appointment::with('user', 'doctor')->latest()->paginate(15);
        return view('receptionist.appointments', compact('appointments'));
    }

    public function patients()
    {
        $patients = User::whereHas('role', function($q) { $q->where('name', 'customer'); })->latest()->paginate(15);
        return view('receptionist.patients', compact('patients'));
    }

    public function doctors()
    {
        $doctors = User::whereHas('role', function($q) { $q->where('name', 'doctor'); })->latest()->get();
        return view('receptionist.doctors', compact('doctors'));
    }

    public function profile()
    {
        return view('receptionist.profile');
    }

    public function password()
    {
        return view('receptionist.password');
    }
}
