<?php

namespace App\Http\Controllers\Nurse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Appointment;
use App\Models\LabRequest;
use App\Models\User;
use App\Models\Ward;
use App\Models\Bed;
use App\Models\MedicalRecord;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'today_patients' => Appointment::whereDate('appointment_date', today())->count(),
            'waiting_queue' => Appointment::where('status', 'pending')->whereDate('appointment_date', today())->count(),
            'occupied_beds' => Bed::where('status', 'occupied')->count(),
            'total_beds' => Bed::count(),
            'pending_labs' => LabRequest::where('status', 'pending')->count(),
        ];

        $recent_patients = User::whereHas('role', function($q) {
            $q->where('name', 'customer');
        })->latest()->limit(5)->get();

        return view('nurse.dashboard', compact('stats', 'recent_patients'));
    }

    public function checkin() { 
        $pending_appointments = Appointment::with('user')
            ->where('status', 'pending')
            ->whereDate('appointment_date', today())
            ->get();
        return view('nurse.checkin', compact('pending_appointments')); 
    }

    public function queue() { 
        $queue = Appointment::with('user', 'doctor')
            ->whereIn('status', ['pending', 'checked_in'])
            ->whereDate('appointment_date', today())
            ->orderBy('created_at', 'asc')
            ->get();
        return view('nurse.queue', compact('queue')); 
    }

    public function vitals() { 
        $patients = User::whereHas('role', function($q) { $q->where('name', 'customer'); })->get();
        return view('nurse.vitals', compact('patients')); 
    }

    public function appointments() { 
        $appointments = Appointment::with('user', 'doctor')
            ->whereDate('appointment_date', today())
            ->get();
        return view('nurse.appointments', compact('appointments')); 
    }

    public function assistDoctor() { 
        $doctors = User::whereHas('role', function($q) { $q->where('name', 'doctor'); })->get();
        return view('nurse.assist_doctor', compact('doctors')); 
    }

    public function patients() { 
        $patients = User::whereHas('role', function($q) { $q->where('name', 'customer'); })->paginate(15);
        return view('nurse.patients', compact('patients')); 
    }

    public function bedAllocation() { 
        $wards = Ward::with('beds')->get();
        $patients = User::whereHas('role', function($q) { $q->where('name', 'customer'); })->get();
        return view('nurse.bed_allocation', compact('wards', 'patients')); 
    }

    public function wardManagement() { 
        $wards = Ward::withCount('beds')->get();
        return view('nurse.wards', compact('wards')); 
    }

    public function labCollection() { 
        $pending_samples = LabRequest::with('patient', 'doctor')
            ->where('status', 'pending')
            ->get();
        return view('nurse.lab_collection', compact('pending_samples')); 
    }

    public function medication() { 
        // Logic for medication administration
        return view('nurse.medication'); 
    }

    public function reports() { 
        return view('nurse.reports'); 
    }

    public function profile() { 
        return view('nurse.profile'); 
    }

    public function password() { 
        return view('nurse.password'); 
    }
}
