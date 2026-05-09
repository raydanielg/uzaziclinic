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
        $invoices = Invoice::with(['user', 'order'])->latest()->paginate(10);
        return view('admin.finance.invoices', compact('invoices'));
    }

    public function receipts()
    {
        $invoices = Invoice::where('status', 'paid')->with(['user'])->latest()->paginate(10);
        return view('admin.finance.receipts', compact('invoices'));
    }

    public function payments()
    {
        return view('admin.finance.payments');
    }

    public function history()
    {
        // For now, listing all invoices as a proxy for payment history
        $invoices = Invoice::with(['user'])->latest()->paginate(10);
        return view('admin.finance.history', compact('invoices'));
    }
}
