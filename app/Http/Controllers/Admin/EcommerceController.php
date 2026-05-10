<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class EcommerceController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        $products = $query->latest()->paginate(10);
        
        $categories = Product::distinct()->pluck('category')->filter();

        $stats = [
            'total_products' => Product::count(),
            'active_orders' => Order::where('status', 'pending')->count(),
            'low_stock' => Product::where('stock_quantity', '<', 10)->count(),
        ];

        if ($request->ajax()) {
            return view('admin.store._product_table', compact('products'))->render();
        }

        return view('admin.store.index', compact('products', 'stats', 'categories'));
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

        $product = Product::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added successfully!',
                'product' => $product
            ]);
        }

        return redirect()->route('admin.store.index')->with('success', 'Product added successfully!');
    }

    public function update(Request $request, Product $product)
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
            // Delete old image if exists
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $data['image'] = 'uploads/products/'.$imageName;
        }

        $product->update($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully!',
                'product' => $product
            ]);
        }

        return redirect()->route('admin.store.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully!'
        ]);
    }

    public function orders()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.store.orders', compact('orders'));
    }

    public function categories()
    {
        $categories = Product::select('category', \DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get();
        return view('admin.store.categories', compact('categories'));
    }

    public function reviews()
    {
        return view('admin.store.reviews');
    }
}
