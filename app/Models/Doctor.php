<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'specialization',
        'license_number',
        'status',
        'bio',
    ];

    public function getDisplayNameAttribute(): string
    {
        if (!empty($this->name)) {
            return $this->name;
        }

        if ($this->relationLoaded('user')) {
            if (!empty($this->user?->name)) {
                return $this->user->name;
            }
        } else {
            try {
                if (!empty($this->user?->name)) {
                    return $this->user->name;
                }
            } catch (\Throwable $e) {
                // ignore
            }
        }

        return 'Doctor #' . $this->id;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
