<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Key metrics
        $totalPatients = Patient::count();
        $totalDoctors = Doctor::where('status', 'active')->count();
        $totalAppointments = Appointment::count();
        $totalRevenue = Payment::where('status', 'completed')->sum('amount') ?? 0;

        // Today's stats
        $todayPatients = Appointment::whereDate('appointment_date', today())->count();
        $todayRevenue = Payment::whereDate('created_at', today())->where('status', 'completed')->sum('amount') ?? 0;

        // Monthly patients trend (last 6 months)
        $monthlyPatients = Appointment::select(
            DB::raw('DATE_FORMAT(appointment_date, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count')
        )
        ->where('appointment_date', '>=', now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // Patients by gender
        $genderStats = Patient::select('gender', DB::raw('COUNT(*) as count'))
            ->groupBy('gender')
            ->get();

        // Appointments by type
        $typeStats = Appointment::select('type', DB::raw('COUNT(*) as count'))
            ->groupBy('type')
            ->get();

        // Appointments by stage (current workflow)
        $stageStats = Appointment::select('current_stage', DB::raw('COUNT(*) as count'))
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->groupBy('current_stage')
            ->get();

        // Revenue by month (last 6 months)
        $monthlyRevenue = Payment::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(amount) as total')
        )
        ->where('status', 'completed')
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // Top doctors by appointments
        $topDoctors = Doctor::withCount('appointments')
            ->orderBy('appointments_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.analytics', compact(
            'totalPatients',
            'totalDoctors',
            'totalAppointments',
            'totalRevenue',
            'todayPatients',
            'todayRevenue',
            'monthlyPatients',
            'genderStats',
            'typeStats',
            'stageStats',
            'monthlyRevenue',
            'topDoctors'
        ));
    }
}
