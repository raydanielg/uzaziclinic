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
            
            return response()->json([
                'success' => true,
                'data' => [
                    'patient' => $patient,
                    'patient_profile' => $patient->patient,
                    'files' => $patientFiles,
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
