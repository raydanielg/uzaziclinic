<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\Order;
use App\Models\User;
use App\Models\PrescriptionItem;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_medicines' => Medicine::count(),
            'low_stock' => Medicine::where('quantity', '<=', 10)->count(),
            'today_prescriptions' => Prescription::whereDate('created_at', today())->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        $low_stock_items = Medicine::where('quantity', '<=', 10)->limit(5)->get();
        $recent_prescriptions = Prescription::with('patient', 'doctor')->latest()->limit(5)->get();

        return view('pharmacist.dashboard', compact('stats', 'low_stock_items', 'recent_prescriptions'));
    }

    public function inventory()
    {
        $medicines = Medicine::paginate(15);
        return view('pharmacist.inventory', compact('medicines'));
    }

    public function prescriptions()
    {
        $prescriptions = Prescription::with('patient', 'doctor')
            ->where('status', 'pending')
            ->latest()
            ->get();
        return view('pharmacist.prescriptions', compact('prescriptions'));
    }

    public function dispense($id)
    {
        $prescription = Prescription::with('patient', 'doctor', 'items.medicine')->findOrFail($id);
        return view('pharmacist.dispense', compact('prescription'));
    }

    public function orders()
    {
        $orders = Order::with('user')->latest()->get();
        return view('pharmacist.orders', compact('orders'));
    }

    public function suppliers()
    {
        return view('pharmacist.suppliers');
    }

    public function alerts()
    {
        $low_stock = Medicine::whereRaw('stock <= min_stock')->get();
        $expired = Medicine::whereDate('expiry_date', '<', today())->get();
        return view('pharmacist.alerts', compact('low_stock', 'expired'));
    }

    public function reports()
    {
        return view('pharmacist.reports');
    }

    public function profile()
    {
        return view('pharmacist.profile');
    }

    public function password()
    {
        return view('pharmacist.password');
    }
}
