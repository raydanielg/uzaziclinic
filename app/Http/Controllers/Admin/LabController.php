<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LabTest;

class LabController extends Controller
{
    public function catalog(Request $request)
    {
        $query = LabTest::with(['patient', 'doctor.user', 'technician']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('test_type') && $request->test_type != '') {
            $query->where('test_type', $request->test_type);
        }

        $labTests = $query->latest()->get();

        $testTypes = LabTest::distinct()->pluck('test_type');
        $patients = \App\Models\Patient::orderBy('name')->get();
        $doctors = \App\Models\Doctor::with('user')->get();

        $stats = [
            'total' => LabTest::count(),
            'pending' => LabTest::where('status', 'pending')->count(),
            'processing' => LabTest::where('status', 'processing')->count(),
            'completed' => LabTest::where('status', 'completed')->count(),
        ];

        if ($request->ajax()) {
            return view('admin.lab._catalog_table', compact('labTests'))->render();
        }

        return view('admin.lab.catalog', compact('labTests', 'stats', 'testTypes', 'patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'test_name' => 'required|string|max:255',
            'test_type' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $labTest = LabTest::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'test_name' => $request->test_name,
            'test_type' => $request->test_type,
            'cost' => $request->cost,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Lab test request created successfully!',
            'data' => $labTest
        ]);
    }

    public function destroy(LabTest $labTest)
    {
        $labTest->delete();
        return response()->json([
            'success' => true,
            'message' => 'Lab test deleted successfully!'
        ]);
    }

    public function results()
    {
        $results = LabTest::with(['patient.user', 'doctor.user'])
            ->where('status', 'completed')
            ->latest()
            ->paginate(15);
        return view('admin.lab.results', compact('results'));
    }

    public function equipment()
    {
        $equipment = \App\Models\LabEquipment::latest()->get();
        return view('admin.lab.equipment', compact('equipment'));
    }

    public function storeEquipment(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255|unique:lab_equipment,serial_number',
            'department' => 'nullable|string|max:255',
            'status' => 'required|in:operational,maintenance,out_of_order,retired',
            'last_maintenance' => 'nullable|date',
            'next_calibration' => 'nullable|date',
        ]);

        $item = \App\Models\LabEquipment::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Equipment registered successfully!',
            'data' => $item
        ]);
    }

    public function destroyEquipment(\App\Models\LabEquipment $equipment)
    {
        $equipment->delete();
        return response()->json([
            'success' => true,
            'message' => 'Equipment deleted successfully!'
        ]);
    }

    public function reports()
    {
        $stats = [
            'total_tests' => LabTest::count(),
            'completed' => LabTest::where('status', 'completed')->count(),
            'pending' => LabTest::where('status', 'pending')->count(),
        ];
        return view('admin.lab.reports', compact('stats'));
    }
}
