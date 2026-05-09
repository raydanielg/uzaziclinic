<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Medicine;
use App\Models\LabTest;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function sales()
    {
        $salesData = Invoice::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(amount) as total')
        )
            ->whereMonth('created_at', now()->month)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $totalSales = Invoice::whereMonth('created_at', now()->month)->sum('amount');
        $totalOrders = Invoice::whereMonth('created_at', now()->month)->count();

        return view('admin.reports.sales', compact('salesData', 'totalSales', 'totalOrders'));
    }

    public function patients()
    {
        $totalPatients = Patient::count();
        $newPatients = Patient::whereMonth('created_at', now()->month)->count();
        $activePatients = Patient::whereHas('appointments', function($q) {
            $q->whereMonth('appointment_date', now()->month);
        })->count();

        $byGender = Patient::select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->get();

        return view('admin.reports.patients', compact('totalPatients', 'newPatients', 'activePatients', 'byGender'));
    }

    public function doctors()
    {
        $doctors = Doctor::with('user')
            ->withCount(['appointments' => function($q) {
                $q->whereMonth('appointment_date', now()->month);
            }])
            ->get();

        $totalDoctors = Doctor::count();
        $activeDoctors = Doctor::where('status', 'active')->count();

        return view('admin.reports.doctors', compact('doctors', 'totalDoctors', 'activeDoctors'));
    }

    public function stock()
    {
        $lowStock = Medicine::where('quantity', '<=', 10)->count();
        $totalItems = Medicine::count();
        $expiringSoon = Medicine::whereBetween('expiry_date', [now(), now()->addMonths(3)])->count();

        $byCategory = Medicine::select('category', DB::raw('count(*) as total'), DB::raw('sum(quantity) as qty'))
            ->groupBy('category')
            ->get();

        return view('admin.reports.stock', compact('lowStock', 'totalItems', 'expiringSoon', 'byCategory'));
    }

    public function revenue()
    {
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $monthlyRevenue = Payment::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->sum('amount');

        $byPaymentMethod = Payment::select('payment_method', DB::raw('sum(amount) as total'))
            ->where('status', 'completed')
            ->groupBy('payment_method')
            ->get();

        $pendingPayments = Invoice::where('status', 'pending')->sum('amount');

        return view('admin.reports.revenue', compact('totalRevenue', 'monthlyRevenue', 'byPaymentMethod', 'pendingPayments'));
    }

    public function appointments()
    {
        $totalAppointments = Appointment::count();
        $thisMonth = Appointment::whereMonth('appointment_date', now()->month)->count();
        $completed = Appointment::where('status', 'completed')->count();
        $cancelled = Appointment::where('status', 'cancelled')->count();

        $byStatus = Appointment::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        return view('admin.reports.appointments', compact('totalAppointments', 'thisMonth', 'completed', 'cancelled', 'byStatus'));
    }
}
