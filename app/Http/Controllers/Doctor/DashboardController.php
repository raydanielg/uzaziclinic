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

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'today_appointments' => Appointment::where('doctor_id', auth()->id())->whereDate('appointment_date', today())->count(),
            'total_patients' => Appointment::where('doctor_id', auth()->id())->distinct('patient_id')->count(),
            'pending_reviews' => Appointment::where('doctor_id', auth()->id())->where('status', 'pending')->count(),
        ];
        
        $recent_appointments = Appointment::with('user')
            ->where('doctor_id', auth()->id())
            ->latest()
            ->limit(5)
            ->get();
            
        return view('doctor.dashboard', compact('stats', 'recent_appointments'));
    }

    public function patients()
    {
        $patients = Appointment::with('user')
            ->where('doctor_id', auth()->id())
            ->select('patient_id')
            ->distinct()
            ->get()
            ->map(function($appointment) {
                return $appointment->user;
            })
            ->filter();

        return view('doctor.patients', compact('patients'));
    }

    public function patientDetails($id)
    {
        $patient = \App\Models\User::findOrFail($id);
        $appointments = Appointment::where('patient_id', $id)
            ->where('doctor_id', auth()->id())
            ->latest()
            ->get();
            
        $medical_records = \App\Models\MedicalRecord::where('patient_id', $id)->latest()->get();
        
        return view('doctor.patient_details', compact('patient', 'appointments', 'medical_records'));
    }
    public function addPrescription() 
    { 
        $patients = Appointment::with('user')
            ->where('doctor_id', auth()->id())
            ->get()
            ->map(function($app) {
                return $app->user;
            })->unique('id');

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
    public function labResults() { return view('doctor.lab_results'); }
    public function medicalRecords() { return view('doctor.medical_records'); }
    public function schedule() { return view('doctor.schedule'); }
    public function chat() { return view('doctor.chat'); }
    public function profile() { return view('doctor.profile'); }
    public function password() { return view('doctor.password'); }
    public function reports() { return view('doctor.reports'); }
}
