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
        $appointments = Appointment::with(['patient.user', 'doctor'])->latest()->paginate(20);
        $patients = Patient::orderBy('name')->get();
        $doctors  = Doctor::with('user')->where('status', 'active')->get();
        return view('admin.appointments.index', compact('appointments', 'patients', 'doctors'));
    }

    public function create()
    {
        $patients = Patient::orderBy('name')->get();
        $doctors = Doctor::with('user')->get();
        return view('admin.appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after:now',
            'symptoms' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'status' => 'pending',
            'symptoms' => $request->symptoms,
        ]);

        return response()->json([
            'success' => true, 
            'message' => 'Appointment scheduled successfully!',
            'data' => $appointment->load(['patient', 'doctor.user'])
        ]);
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled'
        ]);

        $appointment->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Appointment status updated to ' . ucfirst($request->status)
        ]);
    }

    public function quickPatient(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:patients,phone',
            'email' => 'nullable|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // Create user if email provided
        $userId = null;
        if ($request->email) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Hash::make('password'),
                'role_id' => \App\Models\Role::where('name', 'customer')->first()->id ?? null,
                'status' => 'active'
            ]);
            $userId = $user->id;
        }

        $patient = Patient::create([
            'user_id' => $userId,
            'name' => $request->name,
            'phone' => $request->phone,
            'gender' => $request->gender ?? 'unknown',
            'status' => 'active'
        ]);

        return response()->json([
            'success' => true, 
            'message' => 'Patient registered successfully!',
            'data' => $patient
        ]);
    }

    public function upcoming()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->where('appointment_date', '>', now())
            ->where('status', '!=', 'cancelled')
            ->latest()
            ->paginate(10);
        $type = 'Upcoming';
        return view('admin.appointments.index', compact('appointments', 'type'));
    }

    public function history()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->where('appointment_date', '<', now())
            ->latest()
            ->paginate(10);
        $type = 'History';
        return view('admin.appointments.index', compact('appointments', 'type'));
    }

    public function today()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->whereDate('appointment_date', today())
            ->latest()
            ->paginate(10);
        $type = 'Today';
        return view('admin.appointments.index', compact('appointments', 'type'));
    }

    public function cancelled()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->where('status', 'cancelled')
            ->latest()
            ->paginate(10);
        $type = 'Cancelled';
        return view('admin.appointments.index', compact('appointments', 'type'));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient.user', 'doctor.user']);
        $doctors = Doctor::with('user')->where('status', 'active')->get();
        return view('admin.appointments.show', compact('appointment', 'doctors'));
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->update(['status' => 'cancelled']);
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Appointment cancelled successfully.']);
        }
        return back()->with('success', 'Appointment cancelled.');
    }

    public function reassignDoctor(Request $request, Appointment $appointment)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        $appointment->update(['doctor_id' => $request->doctor_id]);

        return response()->json([
            'success' => true,
            'message' => 'Doctor reassigned successfully.',
            'doctor'  => Doctor::with('user')->find($request->doctor_id),
        ]);
    }
}
