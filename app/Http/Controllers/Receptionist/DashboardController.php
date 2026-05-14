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
        $appointments = Appointment::with(['patient.user', 'doctor'])->latest()->paginate(15);
        $patients = Patient::orderBy('name')->get();
        $doctors  = Doctor::with('user')->where('status', 'active')->get();
        return view('receptionist.appointments', compact('appointments', 'patients', 'doctors'));
    }

    public function storeAppointment(Request $request)
    {
        $request->validate([
            'patient_id'       => 'required|exists:patients,id',
            'doctor_id'        => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'type'             => 'nullable|string',
            'notes'            => 'nullable|string',
        ]);

        $datetime = $request->appointment_date . ' ' . $request->appointment_time;

        $appointment = Appointment::create([
            'patient_id'       => $request->patient_id,
            'doctor_id'        => $request->doctor_id,
            'appointment_date' => $datetime,
            'type'             => $request->type ?? 'General Consultation',
            'notes'            => $request->notes,
            'status'           => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Miadi imewekwa!',
            'data'    => $appointment->load(['patient', 'doctor']),
        ]);
    }

    public function updateAppointmentStatus(Request $request, Appointment $appointment)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,completed,cancelled']);
        $appointment->update(['status' => $request->status]);
        return response()->json([
            'success' => true,
            'message' => 'Hali imebadilishwa: ' . ucfirst($request->status),
        ]);
    }

    public function cancelAppointment(Appointment $appointment)
    {
        $appointment->update(['status' => 'cancelled']);
        return response()->json(['success' => true, 'message' => 'Miadi imefutwa.']);
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
