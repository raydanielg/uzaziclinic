<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\PatientFile;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

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

        $recent_appointments = Appointment::with(['patient.user', 'doctor'])->latest()->limit(10)->get();

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

    public function viewPatient($id)
    {
        try {
            $patient = User::with(['role', 'patient'])->findOrFail($id);
            $patientFiles = PatientFile::where('patient_id', $patient->patient->id ?? null)
                ->with('uploadedBy')
                ->latest()
                ->get();
            
            // Get patient history
            $appointments = Appointment::where('user_id', $id)
                ->with(['doctor', 'status'])
                ->latest()
                ->limit(10)
                ->get();
            
            // Get counter data
            $stats = [
                'total_visits' => Appointment::where('user_id', $id)->count(),
                'completed_appointments' => Appointment::where('user_id', $id)->where('status', 'completed')->count(),
                'pending_appointments' => Appointment::where('user_id', $id)->where('status', 'pending')->count(),
                'cancelled_appointments' => Appointment::where('user_id', $id)->where('status', 'cancelled')->count(),
                'total_files' => PatientFile::where('patient_id', $patient->patient->id ?? null)->count(),
            ];
            
            return response()->json([
                'success' => true,
                'data' => [
                    'patient' => $patient,
                    'patient_profile' => $patient->patient,
                    'files' => $patientFiles,
                    'appointments' => $appointments,
                    'stats' => $stats,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load patient: ' . $e->getMessage()
            ], 500);
        }
    }

    public function editPatient($id)
    {
        try {
            $patient = User::with(['role', 'patient'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'patient' => $patient,
                    'patient_profile' => $patient->patient,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load patient: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updatePatient(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'national_id' => 'nullable|string|max:50',
            'blood_type' => 'nullable|string|max:5',
            'insurance_provider' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->status = $request->status;
        $user->save();

        // Update patient profile if exists
        if ($user->patient) {
            $user->patient->update([
                'gender' => $request->gender,
                'blood_group' => $request->blood_type,
                'emergency_contact' => $request->emergency_contact_name . ' - ' . $request->emergency_contact_phone,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Patient updated successfully!',
            'data' => $user->load('patient'),
        ]);
    }

    public function registerPatient(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'national_id' => 'nullable|string|max:50',
            'blood_type' => 'nullable|string|max:5',
            'insurance_provider' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'files' => 'nullable|array|max:5',
            'files.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        // Create user account
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt('password123'), // Default password, user will change on first login
            'status' => 'active',
        ]);

        // Assign customer role
        $customerRole = \App\Models\Role::where('name', 'customer')->first();
        if ($customerRole) {
            $user->role()->associate($customerRole);
            $user->save();
        }

        // Create patient profile
        $patient = Patient::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'gender' => $request->gender,
            'blood_group' => $request->blood_type,
            'allergies' => $request->allergies ?? null,
            'emergency_contact' => $request->emergency_contact_name . ' - ' . $request->emergency_contact_phone,
            'status' => 'active',
        ]);

        // Handle file uploads
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('patient_files/' . $patient->id, $fileName, 'public');
                
                PatientFile::create([
                    'patient_id' => $patient->id,
                    'uploaded_by' => auth()->id(),
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                    'file_type' => $this->determineFileType($file),
                    'file_size' => $this->formatFileSize($file->getSize()),
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Mgonjwa ameshajiliwa kwa mafanikio!',
            'data' => $patient->load('user'),
        ]);
    }

    private function determineFileType($file)
    {
        $extension = $file->getClientOriginalExtension();
        $typeMap = [
            'pdf' => 'medical_report',
            'doc' => 'medical_report',
            'docx' => 'medical_report',
            'jpg' => 'lab_result',
            'jpeg' => 'lab_result',
            'png' => 'lab_result',
        ];
        return $typeMap[$extension] ?? 'other';
    }

    private function formatFileSize($bytes)
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' bytes';
    }

    public function uploadPatientFile(Request $request, Patient $patient)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'file_type' => 'required|in:medical_report,prescription,lab_result,insurance,other',
            'description' => 'nullable|string',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('patient_files/' . $patient->id, $fileName, 'public');

        PatientFile::create([
            'patient_id' => $patient->id,
            'uploaded_by' => auth()->id(),
            'file_name' => $fileName,
            'file_path' => $filePath,
            'file_type' => $request->file_type,
            'file_size' => $this->formatFileSize($file->getSize()),
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Faili limepakiwa kwa mafanikio!',
        ]);
    }

    public function downloadPatientFile(PatientFile $file)
    {
        if (!Storage::disk('public')->exists($file->file_path)) {
            return response()->json(['success' => false, 'message' => 'Faili halipo.'], 404);
        }

        return Storage::disk('public')->download($file->file_path, $file->file_name);
    }

    public function deletePatientFile(PatientFile $file)
    {
        if (Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }

        $file->delete();

        return response()->json([
            'success' => true,
            'message' => 'Faili limefutwa kwa mafanikio!',
        ]);
    }

    public function getPatientFiles(Patient $patient)
    {
        $files = PatientFile::where('patient_id', $patient->id)
            ->with('uploadedBy')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $files,
        ]);
    }

    public function doctors()
    {
        try {
            $doctors = Doctor::with('user')
                ->where('status', 'active')
                ->latest()
                ->get();
            
            return view('receptionist.doctors', compact('doctors'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load doctors: ' . $e->getMessage());
        }
    }

    public function sendPatientToDoctor(Request $request)
    {
        try {
            $request->validate([
                'patient_id' => 'required|exists:users,id',
                'doctor_id' => 'required|exists:users,id',
                'notes' => 'nullable|string|max:500',
            ]);

            $patientUser = User::findOrFail($request->patient_id);
            $doctorUser = User::findOrFail($request->doctor_id);

            // Get patient and doctor records
            $patient = Patient::where('user_id', $patientUser->id)->first();
            $doctor = Doctor::where('user_id', $doctorUser->id)->first();

            if (!$patient) {
                return response()->json([
                    'success' => false,
                    'message' => 'Patient profile not found'
                ], 404);
            }

            if (!$doctor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Doctor profile not found'
                ], 404);
            }

            // Create an appointment
            $appointment = Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'appointment_date' => now()->addMinutes(30),
                'status' => 'pending',
                'symptoms' => $request->notes,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Patient sent to doctor successfully!',
                'appointment_id' => $appointment->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send patient to doctor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function changeDoctor(Request $request)
    {
        try {
            $request->validate([
                'visit_id' => 'required|exists:appointments,id',
                'doctor_id' => 'required|exists:users,id',
                'reason' => 'nullable|string|max:500',
            ]);

            $appointment = Appointment::findOrFail($request->visit_id);
            $doctorUser = User::findOrFail($request->doctor_id);
            $doctor = Doctor::where('user_id', $doctorUser->id)->first();

            if (!$doctor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Doctor profile not found'
                ], 404);
            }

            // Update appointment doctor
            $appointment->update([
                'doctor_id' => $doctor->id,
                'symptoms' => ($appointment->symptoms ?? '') . "\n\n[Doctor Change: " . ($request->reason ?? 'No reason provided') . "]",
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Doctor changed successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to change doctor: ' . $e->getMessage()
            ], 500);
        }
    }

    public function markVisitCompleted(Request $request)
    {
        try {
            $request->validate([
                'visit_id' => 'required|exists:appointments,id',
            ]);

            $appointment = Appointment::findOrFail($request->visit_id);
            $appointment->update(['status' => 'completed']);

            return response()->json([
                'success' => true,
                'message' => 'Visit marked as completed!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark as completed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function processPayment(Request $request)
    {
        try {
            $request->validate([
                'visit_id' => 'required|exists:appointments,id',
                'payment_method' => 'required|in:cash,bank,mobile',
                'payment_details' => 'nullable|string|max:500',
                'amount_received' => 'required|numeric|min:0',
            ]);

            $appointment = Appointment::findOrFail($request->visit_id);
            
            // Update appointment status to completed and record payment
            $appointment->update([
                'status' => 'completed',
                'prescription' => 'Payment Method: ' . $request->payment_method . 
                                "\nAmount Received: TZS " . number_format($request->amount_received) .
                                "\nDetails: " . ($request->payment_details ?? 'N/A')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment processed successfully! Patient discharged.',
                'data' => [
                    'complaint' => $appointment->symptoms ?? 'General Consultation',
                    'diagnosis' => $appointment->diagnosis ?? 'Completed consultation',
                    'payment_method' => ucfirst($request->payment_method),
                    'amount_received' => $request->amount_received,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process payment: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getMedicalDetails(Request $request)
    {
        try {
            $appointment = Appointment::with(['doctor', 'patient'])->findOrFail($request->visit_id);
            
            // Extract payment info from prescription
            $prescription = $appointment->prescription ?? '';
            $paymentMethod = 'N/A';
            $amountPaid = 0;
            
            if (preg_match('/Payment Method: (\w+)/', $prescription, $matches)) {
                $paymentMethod = ucfirst($matches[1]);
            }
            if (preg_match('/Amount Received: TZS ([\d,]+)/', $prescription, $matches)) {
                $amountPaid = (int)str_replace(',', '', $matches[1]);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'doctor' => $appointment->doctor->display_name ?? 'N/A',
                    'date' => $appointment->appointment_date->format('d M Y H:i'),
                    'complaint' => $appointment->symptoms ?? 'N/A',
                    'diagnosis' => $appointment->diagnosis ?? 'N/A',
                    'prescription' => $appointment->prescription ?? 'N/A',
                    'payment_method' => $paymentMethod,
                    'amount_paid' => $amountPaid,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load medical details: ' . $e->getMessage()
            ], 500);
        }
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
