<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient.user', 'doctor.user'])
            ->where('status', '!=', 'cancelled')
            ->orderBy('appointment_date')
            ->get();
        
        $doctors = Doctor::with('user')->where('status', 'active')->get();
        
        return view('admin.calendar.index', compact('appointments', 'doctors'));
    }

    public function create()
    {
        $doctors = Doctor::with('user')->where('status', 'active')->get();
        $patients = Patient::with('user')->get();
        
        return view('admin.calendar.create', compact('doctors', 'patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after:now',
            'symptoms' => 'nullable|string',
        ]);

        // Check for conflicts
        $appointmentDate = $request->appointment_date;
        $doctorId = $request->doctor_id;
        
        $conflict = Appointment::where('doctor_id', $doctorId)
            ->where('status', '!=', 'cancelled')
            ->whereBetween('appointment_date', [
                date('Y-m-d H:i:s', strtotime($appointmentDate) - 3600), // 1 hour before
                date('Y-m-d H:i:s', strtotime($appointmentDate) + 3600)  // 1 hour after
            ])
            ->exists();

        if ($conflict) {
            return back()->with('error', 'This doctor has another appointment at this time. Please choose a different time.');
        }

        Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'symptoms' => $request->symptoms,
            'status' => 'confirmed',
        ]);

        return redirect()->route('admin.calendar.index')
            ->with('success', 'Appointment scheduled successfully');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->update(['status' => 'cancelled']);

        return redirect()->route('admin.calendar.index')
            ->with('success', 'Appointment cancelled successfully');
    }

    public function userSchedule($userId)
    {
        $appointments = Appointment::with(['patient.user', 'doctor.user'])
            ->where('status', '!=', 'cancelled')
            ->where(function($query) use ($userId) {
                $query->whereHas('patient', function($q) use ($userId) {
                    $q->where('user_id', $userId);
                })->orWhereHas('doctor', function($q) use ($userId) {
                    $q->where('user_id', $userId);
                });
            })
            ->orderBy('appointment_date')
            ->get();

        return view('admin.calendar.user-schedule', compact('appointments', 'userId'));
    }
}
