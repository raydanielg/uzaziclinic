<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->latest()->paginate(10);
        $roles = Role::orderBy('name')->get();
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => 'active',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Mtumiaji ameongezwa kikamilifu!');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
            'phone' => ['nullable', 'string', 'max:20'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->phone = $request->phone;
        $user->status = $request->status;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }

    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $user->role_id = $request->role_id;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User role updated successfully!',
            'data' => [
                'user_id' => $user->id,
                'role_id' => $user->role_id,
                'role_name' => optional($user->role)->name,
            ],
        ]);
    }

    public function roles()
    {
        $roles = Role::withCount('users')->get();
        $availablePermissions = [
            'manage_users' => 'Manage Users',
            'manage_roles' => 'Manage Roles',
            'manage_settings' => 'System Settings',
            'view_reports' => 'View Reports',
            'manage_patients' => 'Patient Management',
            'manage_doctors' => 'Doctor Management',
            'manage_appointments' => 'Manage Appointments',
            'manage_stock' => 'Pharmacy Stock',
            'manage_tests' => 'Lab Management',
            'process_orders' => 'E-commerce Orders',
            'manage_finance' => 'Financial Management',
            'all_access' => 'Full System Access (Admin)',
        ];
        return view('admin.users.roles', compact('roles', 'availablePermissions'));
    }

    public function updateRole(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'nullable|array'
        ]);

        $permissions = [];
        if ($request->has('permissions')) {
            foreach ($request->permissions as $perm) {
                $permissions[$perm] = true;
            }
        }

        $role->permissions = $permissions;
        $role->save();

        return redirect()->back()->with('success', 'Role permissions updated successfully!');
    }

    public function destroyRole(Role $role)
    {
        if ($role->users_count > 0) {
            return redirect()->back()->with('error', 'Cannot delete role that has active users!');
        }

        if ($role->name === 'admin') {
            return redirect()->back()->with('error', 'Cannot delete the Super Admin role!');
        }

        $role->delete();
        return redirect()->back()->with('success', 'Role deleted successfully!');
    }

    public function logs()
    {
        $logs = AuditLog::with('user')->latest()->paginate(20);
        return view('admin.users.logs', compact('logs'));
    }
}
