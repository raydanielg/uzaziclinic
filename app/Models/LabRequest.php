<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabRequest extends Model
{
    use HasFactory;

    public const STATUS_PENDING    = 'pending';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_COMPLETED  = 'completed';
    public const STATUS_CANCELLED  = 'cancelled';

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'doctor_id',
        'technician_id',
        'test_names',
        'clinical_notes',
        'priority',
        'status',
        'result_notes',
        'result_data',
        'completed_at',
        'sample_collected_at',
    ];

    protected $casts = [
        'result_data'         => 'array',
        'completed_at'        => 'datetime',
        'sample_collected_at' => 'datetime',
    ];

    /* ── Relationships ───────────────────────────────────────── */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * patient_id stores a USER id (legacy schema). Resolve to Patient via user_id.
     */
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function patientProfile()
    {
        return $this->hasOneThrough(
            Patient::class,
            User::class,
            'id',         // users.id (matches local patient_id)
            'user_id',    // patients.user_id (matches users.id)
            'patient_id', // local key
            'id'          // intermediate key
        );
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    /* ── Scopes ─────────────────────────────────────────────── */
    public function scopePending($q)    { return $q->where('status', self::STATUS_PENDING); }
    public function scopeProcessing($q) { return $q->where('status', self::STATUS_PROCESSING); }
    public function scopeCompleted($q)  { return $q->where('status', self::STATUS_COMPLETED); }
    public function scopeOpen($q)       { return $q->whereIn('status', [self::STATUS_PENDING, self::STATUS_PROCESSING]); }

    /* ── Helpers ────────────────────────────────────────────── */
    public function getTestListAttribute(): array
    {
        if (empty($this->test_names)) return [];
        return array_map('trim', explode(',', $this->test_names));
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING    => 'bg-amber-soft text-amber',
            self::STATUS_PROCESSING => 'bg-blue-soft text-blue',
            self::STATUS_COMPLETED  => 'bg-green-soft text-green',
            self::STATUS_CANCELLED  => 'bg-rose-soft text-rose',
            default                 => 'bg-light text-muted',
        };
    }

    public function getPriorityBadgeAttribute(): string
    {
        return match ($this->priority) {
            'urgent'    => 'bg-amber-soft text-amber',
            'emergency' => 'bg-rose-soft text-rose',
            default     => 'bg-blue-soft text-blue',
        };
    }
}
