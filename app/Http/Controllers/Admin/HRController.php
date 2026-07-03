<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use App\Models\Role;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;

class HRController extends Controller
{
    public function index()
    {
        // Get regular employees
        $regularEmployees = Employee::with('user.role')->get()->map(function($employee) {
            return [
                'id' => $employee->id,
                'type' => 'employee',
                'employee_number' => $employee->employee_number,
                'name' => $employee->full_name,
                'email' => $employee->email,
                'phone' => $employee->phone,
                'department' => $employee->department,
                'position' => $employee->position,
                'status' => $employee->status,
                'role' => $employee->user->role->name ?? 'N/A',
                'created_at' => $employee->created_at,
            ];
        });

        // Get doctors
        $doctors = Doctor::with('user.role')->get()->map(function($doctor) {
            return [
                'id' => $doctor->id,
                'type' => 'doctor',
                'employee_number' => 'DOC-' . str_pad($doctor->id, 4, '0', STR_PAD_LEFT),
                'name' => $doctor->display_name,
                'email' => $doctor->user->email ?? 'N/A',
                'phone' => $doctor->phone,
                'department' => 'medical',
                'position' => $doctor->specialization ?? 'Doctor',
                'status' => $doctor->status,
                'role' => $doctor->user->role->name ?? 'doctor',
                'created_at' => $doctor->created_at,
            ];
        });

        // Combine all staff (employees + doctors)
        $allStaff = collect()
            ->concat($regularEmployees)
            ->concat($doctors)
            ->sortByDesc('created_at')
            ->paginate(15);

        return view('admin.hr.index', compact('allStaff'));
    }

    public function create()
    {
        $roles = Role::whereNotIn('name', ['admin', 'customer'])->orderBy('name')->get();
        return view('admin.hr.create', compact('roles'));
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
            'role_id' => 'required|exists:roles,id',
            'notes' => 'nullable|string',
        ]);

        // Generate employee number
        $lastEmployee = Employee::latest()->first();
        $lastNumber = $lastEmployee ? (int)substr($lastEmployee->employee_number, -4) : 0;
        $employeeNumber = 'EMP-' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        // Create user account for login
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make('password123'),
            'role_id' => $request->role_id,
            'status' => $request->status === 'active' ? 'active' : 'inactive',
        ]);

        Employee::create([
            'user_id' => $user->id,
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
        $employee->load('user');
        $roles = Role::whereNotIn('name', ['admin', 'customer'])->orderBy('name')->get();
        return view('admin.hr.edit', compact('employee', 'roles'));
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
            'role_id' => 'required|exists:roles,id',
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

        // Update linked user account
        if ($employee->user) {
            $employee->user->update([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role_id' => $request->role_id,
                'status' => $request->status === 'active' ? 'active' : 'inactive',
            ]);
        }

        return redirect()->route('admin.hr.index')->with('success', 'Employee updated successfully!');
    }

    public function destroy(Employee $employee)
    {
        $user = $employee->user;
        $employee->delete();
        if ($user) {
            $user->delete();
        }
        return redirect()->route('admin.hr.index')->with('success', 'Employee deleted successfully!');
    }
}
