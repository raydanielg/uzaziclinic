<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicine;

class PharmacyController extends Controller
{
    public function stock(Request $request)
    {
        $query = Medicine::query();

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'low_stock') {
                $query->where('quantity', '<=', 10);
            } elseif ($request->status == 'expired') {
                $query->where('expiry_date', '<', now());
            } elseif ($request->status == 'in_stock') {
                $query->where('quantity', '>', 10)->where('expiry_date', '>=', now());
            }
        }

        $medicines = $query->orderBy('name')->get();
        
        $categories = Medicine::distinct()->pluck('category');

        $stats = [
            'total' => Medicine::count(),
            'low_stock' => Medicine::where('quantity', '<=', 10)->count(),
            'expired' => Medicine::where('expiry_date', '<', now())->count(),
        ];

        if ($request->ajax()) {
            return view('admin.pharmacy._stock_table', compact('medicines'))->render();
        }

        return view('admin.pharmacy.stock', compact('medicines', 'stats', 'categories'));
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();
        return response()->json([
            'success' => true,
            'message' => 'Medicine deleted successfully!'
        ]);
    }

    public function create()
    {
        return view('admin.pharmacy.create');
    }

    public function alerts()
    {
        $alerts = Medicine::where('quantity', '<=', 10)
            ->orWhere('expiry_date', '<', now()->addMonths(3))
            ->orderBy('name')
            ->get();
        return view('admin.pharmacy.alerts', compact('alerts'));
    }

    public function suppliers()
    {
        return view('admin.pharmacy.suppliers');
    }

    public function orders()
    {
        return view('admin.pharmacy.orders');
    }

    public function expiry()
    {
        $expiring = Medicine::where('expiry_date', '<', now()->addMonths(6))
            ->orderBy('expiry_date')
            ->paginate(15);
        return view('admin.pharmacy.expiry', compact('expiring'));
    }
}
