<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_patients' => Patient::count(),
            'total_doctors' => Doctor::count(),
            'today_appointments' => Appointment::whereDate('appointment_date', today())->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_revenue' => (float) Invoice::where('status', 'paid')->sum('amount'),
        ];

        $recentAppointments = Appointment::with([
            'patient.user',
            'doctor.user',
        ])
            ->orderByDesc('appointment_date')
            ->limit(8)
            ->get();

        $months = collect(range(5, 0))
            ->map(fn ($i) => Carbon::now()->startOfMonth()->subMonths($i));

        $labels = $months->map(fn (Carbon $d) => $d->format('M Y'))->values();

        $driver = DB::connection()->getDriverName();
        $ymExpr = match ($driver) {
            'sqlite' => "strftime('%Y-%m', appointment_date)",
            'pgsql' => "to_char(appointment_date, 'YYYY-MM')",
            default => "DATE_FORMAT(appointment_date, '%Y-%m')",
        };

        $appointmentsByMonthRaw = Appointment::query()
            ->selectRaw("{$ymExpr} as ym, COUNT(*) as total")
            ->where('appointment_date', '>=', Carbon::now()->startOfMonth()->subMonths(5))
            ->groupBy('ym')
            ->pluck('total', 'ym');

        $appointmentsByMonth = $months
            ->map(function (Carbon $d) use ($appointmentsByMonthRaw) {
                $key = $d->format('Y-m');
                return (int) ($appointmentsByMonthRaw[$key] ?? 0);
            })
            ->values();

        $orderStatuses = ['pending', 'confirmed', 'completed', 'cancelled'];
        $ordersByStatusRaw = Order::query()
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $ordersByStatus = collect($orderStatuses)
            ->map(fn ($s) => (int) ($ordersByStatusRaw[$s] ?? 0))
            ->values();

        $charts = [
            'appointments' => [
                'labels' => $labels,
                'data' => $appointmentsByMonth,
            ],
            'orders' => [
                'labels' => $orderStatuses,
                'data' => $ordersByStatus,
            ],
        ];

        return view('admin.dashboard', compact('stats', 'recentAppointments', 'charts'));
    }
}
