<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\LabRequest;
use App\Models\LabTest;
use App\Models\LabEquipment;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pending_requests' => LabRequest::where('status', 'pending')->count(),
            'processing_requests' => LabRequest::where('status', 'processing')->count(),
            'completed_today' => LabRequest::where('status', 'completed')->whereDate('updated_at', today())->count(),
            'total_tests' => LabTest::count(),
        ];

        $pending_samples = LabRequest::with('patient', 'doctor')
            ->where('status', 'pending')
            ->latest()
            ->limit(10)
            ->get();

        return view('lab.dashboard', compact('stats', 'pending_samples'));
    }

    public function requests()
    {
        $requests = LabRequest::with('patient', 'doctor')->latest()->paginate(15);
        return view('lab.requests', compact('requests'));
    }

    public function equipment()
    {
        $equipment = LabEquipment::all();
        return view('lab.equipment', compact('equipment'));
    }

    public function tests()
    {
        $tests = LabTest::all();
        return view('lab.tests', compact('tests'));
    }

    public function profile()
    {
        return view('lab.profile');
    }

    public function password()
    {
        return view('lab.password');
    }
}
