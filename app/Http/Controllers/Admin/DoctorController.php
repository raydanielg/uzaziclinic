<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('user')->latest()->paginate(10);
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.doctors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'specialization' => ['nullable', 'string', 'max:255'],
            'license_number' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
            'bio' => ['nullable', 'string'],
        ]);

        $doctorRoleId = Role::where('name', 'doctor')->value('id');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $doctorRoleId,
            'phone' => $request->phone,
            'status' => $request->status,
        ]);

        Doctor::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'specialization' => $request->specialization,
            'license_number' => $request->license_number,
            'status' => $request->status,
            'bio' => $request->bio,
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor created successfully!');
    }
    public function schedules() { return view('admin.doctors.index'); }
    public function specializations() { return view('admin.doctors.index'); }
}
