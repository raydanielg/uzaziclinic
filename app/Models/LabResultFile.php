<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabResultFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'lab_request_id',
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

    public function labRequest()
    {
        return $this->belongsTo(LabRequest::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getFileTypeLabelAttribute()
    {
        $labels = [
            'image' => 'Picha',
            'pdf' => 'PDF',
            'document' => 'Document',
        ];
        return $labels[$this->file_type] ?? 'Unknown';
    }
}
