<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'address',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole($role)
    {
        if (!empty($this->role_id)) {
            $roleName = \App\Models\Role::find($this->role_id)->name ?? null;
            return $roleName === $role;
        }
        return false;
    }

    /**
     * Check if user has a specific permission
     */
    public function hasPermission($permission)
    {
        if (!$this->role) {
            return false;
        }

        $permissions = json_decode($this->role->permissions, true);
        
        if (!$permissions) {
            return false;
        }

        // Admin has all permissions
        if (isset($permissions['all_access']) || isset($permissions['all'])) {
            return true;
        }

        return isset($permissions[$permission]) && $permissions[$permission] === true;
    }

    /**
     * Check if user has any of the given permissions
     */
    public function hasAnyPermission(array $permissions)
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Get the dashboard route URL for this user based on their role.
     */
    public function getDashboardRoute(): string
    {
        $roleName = null;
        if (!empty($this->role_id)) {
            $roleName = \App\Models\Role::find($this->role_id)->name ?? null;
        }

        return match($roleName) {
            'admin'        => route('admin.dashboard'),
            'doctor'       => route('doctor.dashboard'),
            'nurse'        => route('nurse.dashboard'),
            'pharmacist'   => route('pharmacist.dashboard'),
            'lab_tech'     => route('lab.dashboard'),
            'accountant'   => route('accountant.dashboard'),
            'receptionist' => route('receptionist.dashboard'),
            'customer'     => route('patient.dashboard'),
            default        => url('/landing'),
        };
    }
}
