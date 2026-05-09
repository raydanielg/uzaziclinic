<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'gender',
        'status',
        'medical_history',
        'blood_group',
        'allergies',
        'emergency_contact',
    ];

    /**
     * Get the formatted Patient ID (e.g., PT-001)
     */
    public function getPatientNumberAttribute()
    {
        return 'PT-' . str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
