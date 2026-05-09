<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'permissions'];

    protected $casts = [
        'permissions' => 'array',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check if role has a specific permission
     */
    public function hasPermission($permission)
    {
        $permissions = is_string($this->permissions) 
            ? json_decode($this->permissions, true) 
            : $this->permissions;

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
     * Get all permissions as array
     */
    public function getPermissionsArray()
    {
        return is_string($this->permissions) 
            ? json_decode($this->permissions, true) 
            : ($this->permissions ?? []);
    }
}
