<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'status',
        'type',
        'symptoms',
        'notes',
        'diagnosis',
        'prescription',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Relationship: get the patient's linked User account via hasOneThrough.
     * Usage: $appointment->user (or eager-load with 'user').
     * For nested: use with('patient.user') for best performance.
     */
    public function user()
    {
        return $this->hasOneThrough(
            User::class,    // final target
            Patient::class, // intermediary
            'id',           // patients.id  (FK from appointment's patient_id)
            'id',           // users.id     (FK from patient's user_id)
            'patient_id',   // appointments.patient_id (local key)
            'user_id'       // patients.user_id (second local key)
        );
    }

    // ── Scopes ───────────────────────────────────────────────
    public function scopeToday($query)
    {
        return $query->whereDate('appointment_date', today());
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeForDoctor($query, int $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }
}
