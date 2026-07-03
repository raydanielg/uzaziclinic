<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestType;
use Illuminate\Http\Request;

class TestTypeController extends Controller
{
    public function index()
    {
        $testTypes = TestType::orderBy('name')->get();
        $categories = TestType::distinct()->pluck('category')->filter()->sort()->values();
        return view('admin.test_types.index', compact('testTypes', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:test_types,name',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'turnaround_time' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        TestType::create([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'price' => $request->price,
            'turnaround_time' => $request->turnaround_time,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.test-types.index')->with('success', 'Test type created successfully!');
    }

    public function edit(TestType $testType)
    {
        return view('admin.test_types.edit', compact('testType'));
    }

    public function update(Request $request, TestType $testType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:test_types,name,'.$testType->id,
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'turnaround_time' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $testType->update([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'price' => $request->price,
            'turnaround_time' => $request->turnaround_time,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.test-types.index')->with('success', 'Test type updated successfully!');
    }

    public function destroy(TestType $testType)
    {
        $testType->delete();
        return redirect()->route('admin.test-types.index')->with('success', 'Test type deleted successfully!');
    }
}
