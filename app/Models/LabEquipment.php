<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabEquipment extends Model
{
    use HasFactory;

    protected $table = 'lab_equipment';

    protected $fillable = [
        'name',
        'model',
        'serial_number',
        'department',
        'purchase_date',
        'last_maintenance',
        'next_calibration',
        'status',
        'notes',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'last_maintenance' => 'date',
        'next_calibration' => 'date',
    ];

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'operational' => 'bg-success-subtle text-success',
            'maintenance' => 'bg-warning-subtle text-warning',
            'out_of_order' => 'bg-danger-subtle text-danger',
            'retired' => 'bg-secondary-subtle text-secondary',
            default => 'bg-light text-dark',
        };
    }
}
