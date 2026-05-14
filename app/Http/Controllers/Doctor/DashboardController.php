<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;

use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\Patient;
use DB;

use App\Models\LabRequest;
use App\Models\LabTest;
use App\Models\Doctor;

class DashboardController extends Controller
{
    /** Resolve the Doctor record for the currently logged-in doctor user. */
    private function getDoctorId(): ?int
    {
        return Doctor::where('user_id', auth()->id())->value('id');
    }

    public function index()
    {
        $doctorId = $this->getDoctorId();

        $stats = [
            'today_appointments' => Appointment::forDoctor($doctorId)->today()->count(),
            'total_patients'     => Appointment::forDoctor($doctorId)->distinct('patient_id')->count('patient_id'),
            'pending_reviews'    => Appointment::forDoctor($doctorId)->pending()->count(),
            'performance'        => $doctorId
                ? round(Appointment::forDoctor($doctorId)->where('status','completed')->count() /
                    max(1, Appointment::forDoctor($doctorId)->count()) * 100)
                : 0,
        ];

        $recent_appointments = Appointment::with(['patient.user', 'doctor'])
            ->forDoctor($doctorId)
            ->latest()
            ->limit(6)
            ->get();

        return view('doctor.dashboard', compact('stats', 'recent_appointments'));
    }

    public function appointments()
    {
        $doctorId = $this->getDoctorId();
        $appointments = Appointment::with(['patient.user'])
            ->forDoctor($doctorId)
            ->latest()
            ->paginate(15);
        $stats = [
            'today'     => Appointment::forDoctor($doctorId)->today()->count(),
            'pending'   => Appointment::forDoctor($doctorId)->pending()->count(),
            'confirmed' => Appointment::forDoctor($doctorId)->where('status','confirmed')->count(),
            'completed' => Appointment::forDoctor($doctorId)->where('status','completed')->count(),
        ];
        return view('doctor.appointments', compact('appointments', 'stats'));
    }

    public function updateAppointmentStatus(Request $request, Appointment $appointment)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,completed,cancelled']);
        $doctorId = $this->getDoctorId();
        if ($appointment->doctor_id !== $doctorId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        $appointment->update([
            'status'    => $request->status,
            'diagnosis' => $request->diagnosis ?? $appointment->diagnosis,
            'notes'     => $request->notes ?? $appointment->notes,
        ]);
        return response()->json(['success' => true, 'message' => 'Hali imebadilishwa: ' . ucfirst($request->status)]);
    }

    public function patients()
    {
        $doctorId = $this->getDoctorId();
        $patients = Patient::whereIn('id',
            Appointment::forDoctor($doctorId)->pluck('patient_id')
        )->with('user')->latest()->paginate(15);

        return view('doctor.patients', compact('patients'));
    }

    public function patientDetails($id)
    {
        $doctorId  = $this->getDoctorId();
        $patient   = Patient::with('user')->findOrFail($id);
        $appointments = Appointment::with('doctor')
            ->where('patient_id', $id)
            ->forDoctor($doctorId)
            ->latest()
            ->get();
        $medical_records = \App\Models\MedicalRecord::where('patient_id', $id)->latest()->get();
        return view('doctor.patient_details', compact('patient', 'appointments', 'medical_records'));
    }

    public function addPrescription()
    {
        $doctorId = $this->getDoctorId();
        $patients = Patient::whereIn('id',
            Appointment::forDoctor($doctorId)->pluck('patient_id')
        )->with('user')->get();
        $medicines = Medicine::where('status', 'in_stock')->get();
        return view('doctor.prescriptions_add', compact('patients', 'medicines'));
    }

    public function storePrescription(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'diagnosis' => 'nullable',
            'medicines' => 'required|array',
            'medicines.*.name' => 'required',
            'medicines.*.dosage' => 'required',
            'medicines.*.frequency' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $prescription = Prescription::create([
                'patient_id' => $request->patient_id,
                'doctor_id' => auth()->id(),
                'diagnosis' => $request->diagnosis,
                'notes' => $request->notes,
                'status' => 'active'
            ]);

            foreach ($request->medicines as $item) {
                PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'medicine_name' => $item['name'],
                    'dosage' => $item['dosage'],
                    'frequency' => $item['frequency'],
                    'duration' => $item['duration'] ?? null,
                ]);
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Prescription saved successfully!']);
            }

            return redirect()->route('doctor.dashboard')->with('success', 'Prescription saved!');

        } catch (\Exception $e) {
            DB::rollback();
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function labRequests() 
    { 
        $patients = Appointment::with('user')
            ->where('doctor_id', auth()->id())
            ->get()
            ->map(function($app) {
                return $app->user;
            })->unique('id');

        $available_tests = LabTest::where('status', 'active')->get();
        
        $pending_requests = LabRequest::with('patient')
            ->where('doctor_id', auth()->id())
            ->where('status', '!=', 'completed')
            ->latest()
            ->get();

        $completed_results = LabRequest::with('patient')
            ->where('doctor_id', auth()->id())
            ->where('status', 'completed')
            ->latest()
            ->get();

        return view('doctor.lab_requests', compact('patients', 'available_tests', 'pending_requests', 'completed_results')); 
    }

    public function storeLabRequest(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'test_names' => 'required|array',
            'priority' => 'required'
        ]);

        try {
            LabRequest::create([
                'patient_id' => $request->patient_id,
                'doctor_id' => auth()->id(),
                'test_names' => implode(', ', $request->test_names),
                'clinical_notes' => $request->clinical_notes,
                'priority' => $request->priority,
                'status' => 'pending'
            ]);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Lab request submitted successfully!']);
            }

            return back()->with('success', 'Lab request submitted!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function labResults() 
    { 
        $completed_results = LabRequest::with('patient')
            ->where('doctor_id', auth()->id())
            ->where('status', 'completed')
            ->latest()
            ->get();

        return view('doctor.lab_results', compact('completed_results')); 
    }
    public function medicalRecords() 
    { 
        $patients = Appointment::with('user')
            ->where('doctor_id', auth()->id())
            ->get()
            ->map(function($app) {
                return $app->user;
            })->unique('id');

        $medical_records = \App\Models\MedicalRecord::with('patient', 'doctor')
            ->where('doctor_id', auth()->id())
            ->latest()
            ->get();

        return view('doctor.medical_records', compact('medical_records', 'patients')); 
    }
    public function schedule() 
    { 
        $appointments = Appointment::with('user')
            ->where('doctor_id', auth()->id())
            ->whereDate('appointment_date', '>=', today())
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('doctor.schedule', compact('appointments')); 
    }
    public function chat() 
    { 
        $patients = Appointment::with('user')
            ->where('doctor_id', auth()->id())
            ->get()
            ->map(function($app) {
                return $app->user;
            })->unique('id');

        return view('doctor.chat', compact('patients')); 
    }
    public function profile() { return view('doctor.profile'); }
    public function password() { return view('doctor.password'); }
    public function reports() { return view('doctor.reports'); }
}
