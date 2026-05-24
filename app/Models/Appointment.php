<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    /* ── Workflow stages (drives the patient flow) ───────────── */
    public const STAGE_WITH_DOCTOR       = 'with_doctor';
    public const STAGE_AWAITING_LAB      = 'awaiting_lab';
    public const STAGE_LAB_COMPLETE      = 'lab_complete';
    public const STAGE_AWAITING_PHARMACY = 'awaiting_pharmacy';
    public const STAGE_DONE              = 'done';

    public const STAGES = [
        self::STAGE_WITH_DOCTOR       => 'Kwa Daktari',
        self::STAGE_AWAITING_LAB      => 'Kwenye Lab',
        self::STAGE_LAB_COMPLETE      => 'Matokeo Lab Yamekamilika',
        self::STAGE_AWAITING_PHARMACY => 'Kwenye Pharmacy',
        self::STAGE_DONE              => 'Imekamilika',
    ];

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'status',
        'current_stage',
        'type',
        'symptoms',
        'chief_complaint',
        'vital_signs',
        'queue_number',
        'received_by',
        'notes',
        'diagnosis',
        'prescription',
        'completed_at',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
        'completed_at'     => 'datetime',
        'vital_signs'      => 'array',
    ];

    /* ── Relationships ───────────────────────────────────────── */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function receptionist()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function labRequests()
    {
        return $this->hasMany(LabRequest::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    /**
     * Patient's linked user account (via hasOneThrough patient → user).
     */
    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            Patient::class,
            'id', 'id', 'patient_id', 'user_id'
        );
    }

    /* ── Scopes ─────────────────────────────────────────────── */
    public function scopeToday($q)        { return $q->whereDate('appointment_date', today()); }
    public function scopePending($q)      { return $q->where('status', 'pending'); }
    public function scopeActive($q)       { return $q->whereNotIn('status', ['cancelled','completed']); }
    public function scopeForDoctor($q, ?int $doctorId) { return $q->where('doctor_id', $doctorId); }
    public function scopeAtStage($q, string $stage)    { return $q->where('current_stage', $stage); }
    public function scopeInQueue($q)
    {
        return $q->whereIn('current_stage', [
            self::STAGE_WITH_DOCTOR,
            self::STAGE_LAB_COMPLETE,
        ])->whereNotIn('status', ['cancelled','completed']);
    }

    /* ── Helpers ────────────────────────────────────────────── */
    public function moveToStage(string $stage): void
    {
        $this->current_stage = $stage;
        if ($stage === self::STAGE_DONE) {
            $this->status = 'completed';
            $this->completed_at = now();
        }
        $this->save();
    }

    public function getStageLabelAttribute(): string
    {
        return self::STAGES[$this->current_stage] ?? ucfirst((string) $this->current_stage);
    }

    public function getStageBadgeAttribute(): string
    {
        return match ($this->current_stage) {
            self::STAGE_WITH_DOCTOR       => 'bg-blue-soft text-blue',
            self::STAGE_AWAITING_LAB      => 'bg-amber-soft text-amber',
            self::STAGE_LAB_COMPLETE      => 'bg-cyan-soft text-cyan',
            self::STAGE_AWAITING_PHARMACY => 'bg-violet-soft text-violet',
            self::STAGE_DONE              => 'bg-green-soft text-green',
            default                       => 'bg-light text-muted',
        };
    }
}
