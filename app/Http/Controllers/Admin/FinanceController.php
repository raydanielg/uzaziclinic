<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Payment;

class FinanceController extends Controller
{
    public function invoices()
    {
        $invoices = Invoice::with(['user', 'order.user'])->latest()->paginate(10);
        $stats = [
            'total_revenue' => Invoice::where('status', 'paid')->sum('total_amount'),
            'pending_amount' => Invoice::where('status', 'pending')->sum('total_amount'),
            'total_invoices' => Invoice::count(),
            'paid_invoices' => Invoice::where('status', 'paid')->count(),
        ];
        return view('admin.finance.invoices', compact('invoices', 'stats'));
    }

    public function receipts()
    {
        $receipts = Invoice::where('status', 'paid')->with(['user', 'order.user'])->latest()->paginate(10);
        return view('admin.finance.receipts', compact('receipts'));
    }

    public function payments()
    {
        $payments = Payment::with(['user', 'invoice'])->latest()->paginate(10);
        return view('admin.finance.payments', compact('payments'));
    }

    public function history()
    {
        // For now, listing all invoices as a proxy for payment history
        $invoices = Invoice::with(['user', 'order.user'])->latest()->paginate(10);
        return view('admin.finance.history', compact('invoices'));
    }
}
