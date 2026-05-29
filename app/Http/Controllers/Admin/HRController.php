<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use App\Models\Role;

class HRController extends Controller
{
    public function index()
    {
        $employees = Employee::with('user')->latest()->paginate(15);
        return view('admin.hr.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.hr.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'employment_type' => 'required|in:full_time,part_time,contract,intern',
            'department' => 'required|in:medical,nursing,admin,lab,pharmacy,hr,finance,other',
            'position' => 'nullable|string|max:255',
            'hire_date' => 'nullable|date',
            'status' => 'required|in:active,inactive,on_leave,terminated',
            'notes' => 'nullable|string',
        ]);

        // Generate employee number
        $lastEmployee = Employee::latest()->first();
        $lastNumber = $lastEmployee ? (int)substr($lastEmployee->employee_number, -4) : 0;
        $employeeNumber = 'EMP-' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        Employee::create([
            'employee_number' => $employeeNumber,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'employment_type' => $request->employment_type,
            'department' => $request->department,
            'position' => $request->position,
            'hire_date' => $request->hire_date,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.hr.index')->with('success', 'Employee added successfully!');
    }

    public function show(Employee $employee)
    {
        $employee->load('user');
        return view('admin.hr.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('admin.hr.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'phone' => 'required|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'employment_type' => 'required|in:full_time,part_time,contract,intern',
            'department' => 'required|in:medical,nursing,admin,lab,pharmacy,hr,finance,other',
            'position' => 'nullable|string|max:255',
            'hire_date' => 'nullable|date',
            'status' => 'required|in:active,inactive,on_leave,terminated',
            'notes' => 'nullable|string',
        ]);

        $employee->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'employment_type' => $request->employment_type,
            'department' => $request->department,
            'position' => $request->position,
            'hire_date' => $request->hire_date,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.hr.index')->with('success', 'Employee updated successfully!');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('admin.hr.index')->with('success', 'Employee deleted successfully!');
    }
}
