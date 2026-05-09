<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_patients' => User::where('role', 'customer')
                ->orWhereHas('role', function($q) { $q->where('name', 'customer'); })
                ->count(),
            'total_doctors' => User::where('role', 'doctor')
                ->orWhereHas('role', function($q) { $q->where('name', 'doctor'); })
                ->count(),
            'today_appointments' => Appointment::whereDate('appointment_date', today())->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
