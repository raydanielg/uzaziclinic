<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Payment;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_revenue' => Payment::sum('amount'),
            'pending_invoices' => Invoice::where('status', 'pending')->count(),
            'today_payments' => Payment::whereDate('created_at', today())->sum('amount'),
            'total_invoices' => Invoice::count(),
        ];

        $recent_payments = Payment::with('invoice.patient')->latest()->limit(10)->get();

        return view('accountant.dashboard', compact('stats', 'recent_payments'));
    }

    public function invoices()
    {
        $invoices = Invoice::with('patient')->latest()->paginate(15);
        return view('accountant.invoices', compact('invoices'));
    }

    public function payments()
    {
        $payments = Payment::with('invoice.patient')->latest()->paginate(15);
        return view('accountant.payments', compact('payments'));
    }

    public function reports()
    {
        return view('accountant.reports');
    }

    public function profile()
    {
        return view('accountant.profile');
    }

    public function password()
    {
        return view('accountant.password');
    }
}
