<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'prescription_id',
        'medicine_id',
        'medicine_name',
        'quantity',
        'unit_price',
        'dosage',
        'frequency',
        'duration',
        'instructions',
        'dispensed',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'dispensed'  => 'boolean',
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function getLineTotalAttribute(): float
    {
        return (float) ($this->quantity * $this->unit_price);
    }
}
