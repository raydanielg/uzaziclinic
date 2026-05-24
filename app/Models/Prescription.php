<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    public const STATUS_PENDING   = 'pending';
    public const STATUS_DISPENSED = 'dispensed';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_id',
        'diagnosis',
        'notes',
        'status',
        'dispensed_by',
        'dispensed_at',
        'total_cost',
    ];

    protected $casts = [
        'dispensed_at' => 'datetime',
        'total_cost'   => 'decimal:2',
    ];

    /* ── Relationships ───────────────────────────────────────── */
    public function patient()      { return $this->belongsTo(Patient::class); }
    public function doctor()       { return $this->belongsTo(Doctor::class); }
    public function appointment()  { return $this->belongsTo(Appointment::class); }
    public function items()        { return $this->hasMany(PrescriptionItem::class); }
    public function pharmacist()   { return $this->belongsTo(User::class, 'dispensed_by'); }

    /* ── Scopes ─────────────────────────────────────────────── */
    public function scopePending($q)   { return $q->where('status', self::STATUS_PENDING); }
    public function scopeDispensed($q) { return $q->where('status', self::STATUS_DISPENSED); }

    /* ── Helpers ────────────────────────────────────────────── */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING   => 'bg-amber-soft text-amber',
            self::STATUS_DISPENSED => 'bg-green-soft text-green',
            self::STATUS_CANCELLED => 'bg-rose-soft text-rose',
            default                => 'bg-light text-muted',
        };
    }
}
