<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'description',
        'price',
        'turnaround_time',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function scopeActive($q)
    {
        return $q->where('status', 'active');
    }

    public function scopeInactive($q)
    {
        return $q->where('status', 'inactive');
    }

    public function getStatusBadgeAttribute(): string
    {
        return $this->status === 'active'
            ? 'bg-success-subtle text-success'
            : 'bg-secondary-subtle text-secondary';
    }
}
