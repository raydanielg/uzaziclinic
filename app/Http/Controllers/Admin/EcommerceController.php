<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class EcommerceController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        $stats = [
            'total_products' => Product::count(),
            'active_orders' => Order::where('status', 'pending')->count(),
            'low_stock' => Product::where('stock_quantity', '<', 10)->count(),
        ];
        return view('admin.store.index', compact('products', 'stats'));
    }

    public function create()
    {
        return view('admin.store.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'category' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $data['image'] = 'uploads/products/'.$imageName;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Bidhaa imeongezwa kikamilifu!');
    }

    public function orders()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.store.orders', compact('orders'));
    }
}
