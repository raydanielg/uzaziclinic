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

    public function stockSummary()
    {
        $total_value = Medicine::sum(DB::raw('quantity * price'));
        $out_of_stock_count = Medicine::where('quantity', 0)->count();
        $expiring_count = Medicine::whereDate('expiry_date', '<=', today()->addDays(30))->count();
        
        $category_summary = Medicine::select('category', 
            DB::raw('count(*) as count'), 
            DB::raw('sum(quantity * price) as value'))
            ->groupBy('category')
            ->get();

        return view('pharmacist.stock_summary', compact('total_value', 'out_of_stock_count', 'expiring_count', 'category_summary'));
    }

    public function inventory()
    {
        $medicines = Medicine::paginate(15);
        return view('pharmacist.inventory', compact('medicines'));
    }

    public function createMedicine()
    {
        $categories = ['Antibiotics', 'Analgesics', 'Antipyretics', 'Antivirals', 'Supplements'];
        return view('pharmacist.add_medicine', compact('categories'));
    }

    public function stockMove()
    {
        $medicines = Medicine::all();
        return view('pharmacist.stock_move', compact('medicines'));
    }

    public function prescriptions()
    {
        $prescriptions = Prescription::with('patient', 'doctor')
            ->where('status', 'pending')
            ->latest()
            ->get();
        return view('pharmacist.prescriptions', compact('prescriptions'));
    }

    public function prescriptionHistory()
    {
        $history = Prescription::with('patient', 'doctor')
            ->where('status', 'dispensed')
            ->latest()
            ->get();
        return view('pharmacist.prescription_history', compact('history'));
    }

    public function onlineOrders()
    {
        $pending_orders = Order::with('user')->where('status', 'pending')->get();
        return view('pharmacist.online_orders', compact('pending_orders'));
    }

    public function orders()
    {
        $orders = Order::with('user')->latest()->get();
        return view('pharmacist.orders', compact('orders'));
    }

    public function settings()
    {
        $categories = Medicine::distinct()->pluck('category');
        return view('pharmacist.settings', compact('categories'));
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
