<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use App\Models\Role;
use App\Models\Doctor;

class HRController extends Controller
{
    public function index()
    {
        // Get regular employees
        $regularEmployees = Employee::with('user')->get()->map(function($employee) {
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
                'created_at' => $employee->created_at,
            ];
        });

        // Get doctors
        $doctors = Doctor::with('user')->get()->map(function($doctor) {
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
                'created_at' => $doctor->created_at,
            ];
        });

        // Get nurses (users with nurse role)
        $nurseRole = Role::where('name', 'nurse')->first();
        $nurses = [];
        if ($nurseRole) {
            $nurses = User::where('role_id', $nurseRole->id)->get()->map(function($nurse) {
                return [
                    'id' => $nurse->id,
                    'type' => 'nurse',
                    'employee_number' => 'NUR-' . str_pad($nurse->id, 4, '0', STR_PAD_LEFT),
                    'name' => $nurse->name,
                    'email' => $nurse->email,
                    'phone' => $nurse->phone ?? 'N/A',
                    'department' => 'nursing',
                    'position' => 'Nurse',
                    'status' => $nurse->status ?? 'active',
                    'created_at' => $nurse->created_at,
                ];
            });
        }

        // Combine all staff
        $allStaff = collect()
            ->concat($regularEmployees)
            ->concat($doctors)
            ->concat($nurses)
            ->sortByDesc('created_at')
            ->paginate(15);

        return view('admin.hr.index', compact('allStaff'));
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
