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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'expiry_date' => 'required|date|after_or_equal:today',
            'description' => 'nullable|string',
        ]);

        Medicine::create([
            'name' => $request->name,
            'category' => $request->category,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'expiry_date' => $request->expiry_date,
            'description' => $request->description,
            'status' => 'active'
        ]);

        return redirect()->route('admin.pharmacy.stock')->with('success', 'Medicine added successfully!');
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
