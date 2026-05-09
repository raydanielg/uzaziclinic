<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LabTest;

class LabController extends Controller
{
    public function catalog()
    {
        $labTests = LabTest::with(['patient.user', 'doctor.user', 'technician'])
            ->latest()
            ->paginate(15);
        $stats = [
            'total' => LabTest::count(),
            'pending' => LabTest::where('status', 'pending')->count(),
            'processing' => LabTest::where('status', 'processing')->count(),
            'completed' => LabTest::where('status', 'completed')->count(),
        ];
        return view('admin.lab.catalog', compact('labTests', 'stats'));
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
        return view('admin.lab.equipment');
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
