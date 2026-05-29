<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'uploaded_by',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getFileTypeLabelAttribute()
    {
        $labels = [
            'medical_report' => 'Medical Report',
            'prescription' => 'Prescription',
            'lab_result' => 'Lab Result',
            'insurance' => 'Insurance',
            'other' => 'Other',
        ];
        return $labels[$this->file_type] ?? 'Unknown';
    }
}
