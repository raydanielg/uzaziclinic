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
        $users = \App\Models\User::all();
        $orders = \App\Models\Order::whereDoesntHave('invoice')->get();
        $stats = [
            'total_revenue' => Invoice::where('status', 'paid')->sum('total_amount'),
            'pending_amount' => Invoice::where('status', 'pending')->sum('total_amount'),
            'total_invoices' => Invoice::count(),
            'paid_invoices' => Invoice::where('status', 'paid')->count(),
        ];
        return view('admin.finance.invoices', compact('invoices', 'stats', 'users', 'orders'));
    }

    public function storeInvoice(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'order_id' => 'nullable|exists:orders,id',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,paid,cancelled',
            'notes' => 'nullable|string',
        ]);

        $invoice = Invoice::create([
            'user_id' => $request->user_id,
            'order_id' => $request->order_id,
            'total_amount' => $request->total_amount,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Invoice created successfully!',
                'invoice' => $invoice
            ]);
        }

        return redirect()->route('admin.finance.invoices')->with('success', 'Invoice created successfully!');
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
