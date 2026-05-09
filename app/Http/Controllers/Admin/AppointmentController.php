<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\User;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor'])->latest()->paginate(10);
        return view('admin.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        return view('admin.appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after:now',
            'symptoms' => 'nullable|string',
        ]);

        Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'status' => 'pending',
            'symptoms' => $request->symptoms,
        ]);

        return redirect()->route('admin.appointments.index')->with('success', 'Miadi imewekwa kikamilifu!');
    }

    public function upcoming()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->where('appointment_date', '>', now())
            ->where('status', '!=', 'cancelled')
            ->latest()
            ->paginate(10);
        return view('admin.appointments.index', compact('appointments'));
    }

    public function history()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->where('appointment_date', '<', now())
            ->latest()
            ->paginate(10);
        return view('admin.appointments.index', compact('appointments'));
    }

    public function today()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->whereDate('appointment_date', today())
            ->latest()
            ->paginate(10);
        return view('admin.appointments.index', compact('appointments'));
    }

    public function cancelled()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->where('status', 'cancelled')
            ->latest()
            ->paginate(10);
        return view('admin.appointments.index', compact('appointments'));
    }
}
