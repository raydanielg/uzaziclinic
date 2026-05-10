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

        $doctorRoleId = Role::where('name', 'doctor')->value('id');
        $doctorUsersMissingProfile = collect();
        if ($doctorRoleId) {
            $doctorUsersMissingProfile = User::with(['role', 'doctor'])
                ->where('role_id', $doctorRoleId)
                ->whereDoesntHave('doctor')
                ->orderBy('name')
                ->get();
        }

        return view('admin.doctors.index', compact('doctors', 'doctorUsersMissingProfile'));
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

    public function createProfileFromUser(User $user)
    {
        $doctorRoleId = Role::where('name', 'doctor')->value('id');
        if (!$doctorRoleId || (int)$user->role_id !== (int)$doctorRoleId) {
            return redirect()->back()->with('error', 'Selected user is not a doctor.');
        }

        Doctor::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name,
                'phone' => $user->phone,
                'status' => $user->status ?? 'active',
                'specialization' => 'General',
            ]
        );

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor profile created successfully!');
    }
    public function schedules()
    {
        $doctors = Doctor::with('user')->get();
        return view('admin.doctors.schedules', compact('doctors'));
    }

    public function specializations()
    {
        $specializations = Doctor::whereNotNull('specialization')
            ->distinct()
            ->pluck('specialization');
        return view('admin.doctors.specializations', compact('specializations'));
    }
}
